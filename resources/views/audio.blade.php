<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>単語ごとの発音評価</title>
  <!-- Azure Speech SDK の CDN -->
  <script src="https://aka.ms/csspeech/jsbrowserpackageraw"></script>
  <!-- CSRFトークン（Ajax送信時に必要） -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <h1>単語ごとの発音評価（自動停止＆手動停止）</h1>

  @foreach($words as $index => $word)
    <div id="evaluation-{{ $index }}" style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
      <h2>対象単語: {{ $word }}</h2>
      <button class="start-btn" data-index="{{ $index }}">評価開始</button>
      <button class="stop-btn" data-index="{{ $index }}" disabled>評価停止</button>
      <pre id="result-{{ $index }}"></pre>
    </div>
  @endforeach

  <!-- 保存ボタン -->
  <button id="submitEvaluation">評価を保存</button>

  <script>
    // .env から埋め込んだキー・リージョン（本番ではキーの扱いに注意）
    const subscriptionKey = "{{ env('AZURE_SPEECH_KEY') }}";
    const serviceRegion   = "{{ env('AZURE_SPEECH_REGION') }}";

    // Blade から渡された words 配列を JS 変数に
    const words = {!! json_encode($words) !!};

    // Speech SDK の基本設定
    const speechConfig = SpeechSDK.SpeechConfig.fromSubscription(subscriptionKey, serviceRegion);
    speechConfig.speechRecognitionLanguage = "ko-KR";

    // 各単語ごとの SpeechRecognizer インスタンスを保持するオブジェクト
    const recognizers = {};

    // 単語ごとの認識結果を格納する配列
    window.evaluationResults = [];

    // -----------------------
    // 評価開始ボタン
    // -----------------------
    document.querySelectorAll('.start-btn').forEach(button => {
      button.addEventListener('click', function() {
        const index = this.getAttribute('data-index');
        const targetWord = words[index];

        // 発音評価設定を作成
        const paConfig = new SpeechSDK.PronunciationAssessmentConfig(
          targetWord,
          SpeechSDK.PronunciationAssessmentGradingSystem.HundredMark,
          SpeechSDK.PronunciationAssessmentGranularity.Phoneme,
          true
        );

        // マイク入力設定
        const audioConfig = SpeechSDK.AudioConfig.fromDefaultMicrophoneInput();
        // SpeechRecognizer を生成
        const recognizer = new SpeechSDK.SpeechRecognizer(speechConfig, audioConfig);

        // 発音評価設定を適用
        paConfig.applyTo(recognizer);
        recognizers[index] = recognizer;

        // 結果表示エリア
        const resultElem = document.getElementById(`result-${index}`);
        resultElem.innerText = "認識開始...\n";

        // 連続認識を開始
        recognizer.startContinuousRecognitionAsync(
          () => {
            // ボタンの有効/無効切り替え
            this.disabled = true;
            document.querySelector(`.stop-btn[data-index="${index}"]`).disabled = false;
          },
          err => {
            console.error(err);
            resultElem.innerText += "\n認識開始エラー: " + err;
          }
        );

        // recognized イベント: 認識成功時に呼ばれる
        recognizer.recognized = (s, e) => {
          if (e.result.reason === SpeechSDK.ResultReason.RecognizedSpeech) {
            try {
              const jsonResult = JSON.parse(e.result.json);
              resultElem.innerText += "\n認識結果: " + jsonResult.DisplayText;

              if (jsonResult.NBest && jsonResult.NBest.length > 0) {
                const best = jsonResult.NBest[0];
                if (best.PronunciationAssessment) {
                  const pa = best.PronunciationAssessment;
                  resultElem.innerText += "\n発音評価:";
                  resultElem.innerText += "\n  AccuracyScore: " + pa.AccuracyScore;
                  resultElem.innerText += "\n  FluencyScore: " + pa.FluencyScore;
                  resultElem.innerText += "\n  CompletenessScore: " + pa.CompletenessScore;
                  resultElem.innerText += "\n  PronScore: " + pa.PronScore;

                  // 結果を配列に保存
                  window.evaluationResults[index] = {
                    word: targetWord,
                    recognizedText: jsonResult.DisplayText,
                    accuracyScore: pa.AccuracyScore,
                    fluencyScore: pa.FluencyScore,
                    completenessScore: pa.CompletenessScore,
                    pronScore: pa.PronScore
                  };
                } else {
                  resultElem.innerText += "\n発音評価情報がありません。";
                }
              } else {
                resultElem.innerText += "\nNBest情報がありません。";
              }
            } catch (err) {
              resultElem.innerText += "\nJSONパースエラー: " + err;
            }

            // ---- ここで自動的に停止する ----
            recognizer.stopContinuousRecognitionAsync(
              () => {
                document.querySelector(`.start-btn[data-index="${index}"]`).disabled = false;
                document.querySelector(`.stop-btn[data-index="${index}"]`).disabled = true;
                resultElem.innerText += "\n自動的に評価を終了しました。";
              },
              stopErr => {
                console.error(stopErr);
                resultElem.innerText += "\n停止エラー: " + stopErr;
              }
            );
          }
        };

        // canceled イベントやエラー時の処理
        recognizer.canceled = (s, e) => {
          console.error("キャンセルまたはエラー:", e);
          resultElem.innerText += "\nキャンセルまたはエラー: " + JSON.stringify(e);
        };
      });
    });

    // -----------------------
    // 評価停止ボタン（手動停止）
    // -----------------------
    document.querySelectorAll('.stop-btn').forEach(button => {
      button.addEventListener('click', function() {
        const index = this.getAttribute('data-index');
        const recognizer = recognizers[index];
        const resultElem = document.getElementById(`result-${index}`);
        if (recognizer) {
          recognizer.stopContinuousRecognitionAsync(
            () => {
              document.querySelector(`.start-btn[data-index="${index}"]`).disabled = false;
              this.disabled = true;
              resultElem.innerText += "\n手動で評価を終了しました。";
            },
            err => {
              console.error(err);
              resultElem.innerText += "\n停止エラー: " + err;
            }
          );
        }
      });
    });

    // -----------------------
    // 「評価を保存」ボタン
    // -----------------------
    document.getElementById("submitEvaluation").addEventListener("click", function() {
      // undefined が混ざらないようにフィルタ
      const filteredResults = window.evaluationResults.filter(r => r !== undefined);
      if (filteredResults.length === 0) {
        alert("評価結果がありません。先に発音評価を行ってください。");
        return;
      }

      fetch('{{ route("evaluation.store") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ evaluations: filteredResults })
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        alert('評価結果が保存されました。サーバーからのメッセージ: ' + data.message);
      })
      .catch(error => {
        console.error('Error:', error);
        alert('評価結果の保存に失敗しました。');
      });
    });
  </script>
</body>
</html>