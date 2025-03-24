<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class AudioController extends Controller
{
    public function index()
    {
        return view('audio')->with(['words' => $word->get()]);
    }
    public function store(Request $request)
    {
        // 送信された評価結果を取得
        $evaluations = $request->input('evaluations', []);
        // デバッグ用に確認したい場合はコメントアウトを外す
        //dd($evaluations);
        // ここで DB 保存などを行う
        // 例:
        // foreach ($evaluations as $evaluation) {
        //     // $evaluation['word']
        //     // $evaluation['recognizedText']
        //     // $evaluation['accuracyScore']
        //     // $evaluation['fluencyScore']
        //     // $evaluation['completenessScore']
        //     // $evaluation['pronScore']
        //     // ...
        // }
        // 正常に処理が終わったら JSON を返す
        return response()->json([
            'message' => '保存が完了しました',
            'receivedCount' => count($evaluations),
        ]);
    }
}