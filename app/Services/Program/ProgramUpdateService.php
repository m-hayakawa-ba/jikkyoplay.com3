<?php

namespace App\Services\Program;

use App\Models\Program;

class ProgramUpdateService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private Program $programModel,
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
}