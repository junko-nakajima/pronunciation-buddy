<x-app-layout>
  <x-slot name="header">
      <meta charset="utf-8">
      <title>발음 버디</title>
  </x-slot>
  <!DOCTYPE html>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
      <head>
          <meta charset="utf-8">
          <title>발음 버디</title>
          <!-- Fonts -->
          <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
          <script src="https://aka.ms/csspeech/jsbrowserpackageraw"></script>
      </head>
      <body>
          <h1>{{ $deck->title }}</h1>
          @auth
            @if (Auth::user()->is_teacher)
            <a href="/words/{{ $deck->id }}/create">create</a>
            @endif
          @endauth
          <div class='words'>
              @foreach ($words as $word)
                  <div class='word' id="word-{{ $word->id }}">
                      <h2 class='title'>
                          <a href="/words/{{ $word->id }}">{{ $word->word }}</a>
                      </h2>
                      <p class='meaning'>{{ $word->meaning }}</p>
                  </div>
                  <!-- 発音評価開始ボタン -->
                  <button class="start-btn" data-word-id="{{ $word->id }}">
                      発音評価開始
                  </button>
                  <!-- 発音評価停止ボタン（初期状態は無効） -->
                  <button class="stop-btn" data-word-id="{{ $word->id }}" disabled>
                      評価停止
                  </button>
                  <!-- 評価結果表示エリア -->
                  <pre id="result-{{ $word->id }}"></pre>
                  @auth
                  @if (Auth::user()->is_teacher)
                  <form action="/words/{{ $word->id }}" id="form_{{ $word->id }}" method="word">
                      @csrf
                      @method('DELETE')
                      <button type="button" onclick="deleteWord({{ $word->id }})">delete</button>
                  </form>
                  <div class="edit"><a href="/words/{{ $word->id }}/edit">edit</a></div>
                  @endif
                  @endauth
              @endforeach
              {{ Auth::user()->name }}
          </div>
          <script>
              // ========================================
              // 1) Azure Speech SDK の初期化
              // ========================================
              const subscriptionKey = "{{ env('AZURE_SPEECH_KEY') }}";    // .envからキーを取得
              const serviceRegion   = "{{ env('AZURE_SPEECH_REGION') }}"; // .envからリージョンを取得
              const speechConfig = SpeechSDK.SpeechConfig.fromSubscription(subscriptionKey, serviceRegion);
              speechConfig.speechRecognitionLanguage = "ko-KR"; // 必要に応じて変更 ("ko-KR", "en-US" など)

              // グローバルに各認識インスタンスを保持するためのオブジェクト
              window.recognizers = {};

              // ========================================
              // 2) 発音評価開始ボタンのクリックイベント（連続認識）
              // ========================================
              document.querySelectorAll('.start-btn').forEach(button => {
                  button.addEventListener('click', function() {
                      const wordId = this.getAttribute('data-word-id');
                      const wordElement = document.getElementById('word-' + wordId);
                      const resultElem  = document.getElementById('result-' + wordId);
                      // Blade テンプレート上のテキスト（参照テキスト）を取得
                      const wordTitle = (wordElement.innerText || "").trim();
                      // 結果表示を初期化
                      resultElem.innerText = "認識開始...\n";

                      // ========================================
                      // 3) 発音評価の設定を作成
                      // ========================================
                      const paConfig = new SpeechSDK.PronunciationAssessmentConfig(
                          wordTitle,  // 参照テキスト
                          SpeechSDK.PronunciationAssessmentGradingSystem.HundredMark, // 100点満点評価
                          SpeechSDK.PronunciationAssessmentGranularity.Phoneme,       // 音素単位
                          true  // ミスを検出するか
                      );
                      // マイク入力の設定
                      const audioConfig = SpeechSDK.AudioConfig.fromDefaultMicrophoneInput();
                      // SpeechRecognizer の生成
                      const recognizer = new SpeechSDK.SpeechRecognizer(speechConfig, audioConfig);
                      // 発音評価設定を適用
                      paConfig.applyTo(recognizer);

                      // グローバル保存（停止時に参照するため）
                      window.recognizers[wordId] = recognizer;

                      // ボタンの状態切り替え
                      this.disabled = true;
                      document.querySelector(`.stop-btn[data-word-id="${wordId}"]`).disabled = false;

                      // 連続認識時の認識結果イベントハンドラ
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
                                      } else {
                                          resultElem.innerText += "\n発音評価情報がありません。";
                                      }
                                  } else {
                                      resultElem.innerText += "\nNBest情報がありません。";
                                  }
                              } catch (err) {
                                  resultElem.innerText += "\nJSONパースエラー: " + err;
                              }
                          }
                      };

                      // エラーまたはキャンセル時のハンドラ
                      recognizer.canceled = (s, e) => {
                          console.error("キャンセルまたはエラー:", e);
                          resultElem.innerText += "\nキャンセルまたはエラー: " + JSON.stringify(e);
                      };

                      // 連続認識の開始
                      recognizer.startContinuousRecognitionAsync(
                          () => {
                              console.log("連続認識が開始されました。");
                          },
                          err => {
                              console.error(err);
                              resultElem.innerText += "\n認識開始エラー: " + err;
                          }
                      );
                  });
              });

              // ========================================
              // 3) 発音評価停止ボタンのクリックイベント
              // ========================================
              document.querySelectorAll('.stop-btn').forEach(button => {
                  button.addEventListener('click', function() {
                      const wordId = this.getAttribute('data-word-id');
                      const recognizer = window.recognizers[wordId];
                      const resultElem = document.getElementById('result-' + wordId);
                      if (recognizer) {
                          recognizer.stopContinuousRecognitionAsync(
                              () => {
                                  document.querySelector(`.start-btn[data-word-id="${wordId}"]`).disabled = false;
                                  this.disabled = true;
                                  resultElem.innerText += "\n評価を停止しました。";
                              },
                              err => {
                                  console.error(err);
                                  resultElem.innerText += "\n停止エラー: " + err;
                              }
                          );
                      }
                  });
              });

              // ----------------------------------------
              // 削除ボタンの処理（例）
              // ----------------------------------------
              function deleteWord(id) {
                  'use strict';
                  if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                      document.getElementById(`form_${id}`).submit();
                  }
              }
          </script>
      </body>
      <div class="back">[<a href="{{ url()->previous() }}">back</a>]</div>
  </html>
</x-app-layout>