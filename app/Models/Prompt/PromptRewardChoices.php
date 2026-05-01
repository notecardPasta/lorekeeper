<?php

namespace App\Models\Prompt;

use App\Models\Model;

class PromptRewardChoices extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prompt_id', 'reward_choice_group_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prompt_reward_choices';
    /**
     * Validation rules for creation.
     *
     * @var array
     */
    public static $createRules = [
        'rewardable_type' => 'required',
        'rewardable_id'   => 'required',
        'quantity'        => 'required|integer|min:1',
    ];

    /**
     * Validation rules for updating.
     *
     * @var array
     */
    public static $updateRules = [
        'rewardable_type' => 'required',
        'rewardable_id'   => 'required',
        'quantity'        => 'required|integer|min:1',
    ];

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************

    /**
     * Get the choice group.
     */
    public function group() {
        return $this->belongsTo(RewardChoiceGroup::class, 'reward_choice_group_id');
    }
}
