<?php

namespace App\Services\Program;

use Illuminate\Support\Facades\DB;
use App\Models\Program;
use App\Services\FixProgramInformation\FixProgramInformationCreateService;

class ProgramUpdateService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private Program $programModel,
        private FixProgramInformationCreateService $fixProgramInformationCreateService,
    ) {
    }

    /**
     * 動画情報の更新
     * 
     * @param int   $program_id 更新する動画id
     * @param array $params     更新するカラムと値の配列
     * 
     * @param bool 更新に成功したらtrue
     */
    public function updateProgram(int $program_id, array $params) : bool
    {
        //情報を更新する
        $count = $this->programModel
            ->where('id', $program_id)
            ->update($params);
        
        //成否を返す
        return $count > 0;
    }

    /**
     * 動画の音声情報を更新する
     * 
     * @param int $program_id    更新する動画id
     * @param int $creater_id    動画の実況者id
     * @param int $voice_id      更新後の音声id
     * @param bool $all_flag     その実況者の動画の音声idをすべて更新する
     * @param string $ip_address 変更したユーザーのIPアドレス
     * 
     * @return bool 更新に成功したらtrue
     */
    public function updateVoiceId(int $program_id, int $creater_id, int $voice_id, bool $all_flag, string $ip_address) : bool
    {
        //その実況者の動画をすべて更新する場合
        if ($all_flag) {
            $query = $this->programModel
                ->where('voice_id', '!=', $voice_id)
                ->whereHas('creater', function ($q) use ($creater_id) {
                    $q->where('id', $creater_id);
                });
        }

        //動画を一つだけ更新する場合
        else {
            $query = $this->programModel
                ->where('voice_id', '!=', $voice_id)
                ->where('id', $program_id);
        }

        //更新する動画を取得
        $programs = $query->get();

        //トランザクション処理の開始
        DB::beginTransaction();
        try {

            //変更履歴を記憶
            foreach($programs as $program) {
                $this->fixProgramInformationCreateService->createVoiceUpdate(
                    $program->id,
                    $program->voice_id,
                    $voice_id,
                    $ip_address,
                );
            }

            //音声情報を更新する
            $count = $query->update(['voice_id' => $voice_id]);

            //トランザクション処理の終了
            DB::commit();

        } catch (\Throwable $e) {

            DB::rollback();
            return false;
        }

        
        //成否を返す
        return $count > 0;
    }
}