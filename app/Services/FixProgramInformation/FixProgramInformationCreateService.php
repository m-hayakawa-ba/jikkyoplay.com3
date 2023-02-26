<?php

namespace App\Services\FixProgramInformation;

use App\Models\FixProgramInformation;

class FixProgramInformationCreateService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private FixProgramInformation $fixProgramInformationModel
    ) {
    }

    /**
     * 音声の変更履歴を作成
     * 
     * @param int program_id
     * @param int $old_voice_id
     * @param int $new_voice_id
     * @param string $ip_address
     */
    public function createVoiceUpdate(int $program_id, int $old_voice_id, int $new_voice_id, string $ip_address)
    {
        $this->fixProgramInformationModel->create(compact(
            'program_id',
            'old_voice_id',
            'new_voice_id',
            'ip_address',
        ));
    }

    /**
     * ゲームidの変更履歴を作成
     * 
     * @param int program_id
     * @param int $old_game_id
     * @param int $new_game_id
     * @param string $ip_address
     */
    public function createGameUpdate(int $program_id, int $old_game_id, int $new_game_id, string $ip_address)
    {
        $this->fixProgramInformationModel->create(compact(
            'program_id',
            'old_game_id',
            'new_game_id',
            'ip_address',
        ));
    }
}