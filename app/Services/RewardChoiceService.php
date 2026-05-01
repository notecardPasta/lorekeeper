<?php

namespace App\Services;

use App\Models\Prompt\Prompt;
use App\Models\Prompt\RewardChoiceGroup;
use App\Models\Prompt\RewardChoices;
use App\Models\Prompt\PromptRewardChoices;
use App\Models\Submission\Submission;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class RewardChoiceService extends Service {
    /*
    |--------------------------------------------------------------------------
    | Prompt Service
    |--------------------------------------------------------------------------
    |
    | Handles the creation and editing of prompt categories and prompts.
    |
    */

    /**********************************************************************************************

        REWARD CHOICES

    **********************************************************************************************/

    /**
     * Create a reward choice group.
     *
     * @param array                 $data
     * @param \App\Models\User\User $user
     *
     * @return bool|RewardChoiceGroup
     */
    public function createRewardChoiceGroup($data, $user) {
        DB::beginTransaction();

        try {
            $data = $this->populateRewardChoiceData($data);

            $group = RewardChoiceGroup::create($data);

            return $this->commitReturn($group);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Update a reward choice gorup.
     *
     * @param RewardChoiceGroup        $group
     * @param array                 $data
     * @param \App\Models\User\User $user
     *
     * @return bool|RewardChoiceGroup
     */
    public function updateRewardChoiceGroup($group, $data, $user) {
        DB::beginTransaction();

        try {
            // More specific validation
            if (RewardChoiceGroup::where('name', $data['name'])->where('id', '!=', $group->id)->exists()) {
                throw new \Exception('The name has already been taken.');
            }

            $data = $this->populateRewardChoiceData($data, $group);

            $group->update($data);
            
            $this->populateRewards(Arr::only($data, ['rewardable_type', 'rewardable_id', 'quantity']), $group);

            return $this->commitReturn($group);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Delete a category.
     *
     * @param RewardChoiceGroup $group
     *
     * @return bool
     */
    public function deleteRewardChoiceGroup($group) {
        DB::beginTransaction();

        try {
            // Check first if the category is currently in use
            if (PromptRewardChoices::where('prompt_category_id', $group->id)->exists()) {
                throw new \Exception('A prompt with this reward group exists. Please change its reward group first.');
            }

            $group->delete();

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }


    /**
     * Handle choice group data.
     *
     * @param array               $data
     * @param RewardChoiceGroup|null $group
     *
     * @return array
     */
    private function populateRewardChoiceData($data, $group = null) {

        return $data;
    }

    /**
     * Processes user input for creating/updating prompt rewards.
     *
     * @param array  $data
     * @param RewardChoiceGroup $group
     */
    private function populateRewards($data, $group) {
        // Clear the old rewards...
        $group->choices()->delete();
        
        if (isset($data['rewardable_type'])) {
            foreach ($data['rewardable_type'] as $key => $type) {
                RewardChoices::create([
                    'choice_group_id'  => $group->id,
                    'rewardable_type' => $type,
                    'rewardable_id'   => $data['rewardable_id'][$key],
                    'quantity'        => $data['quantity'][$key],
                ]);
            }
        }
    }

}
