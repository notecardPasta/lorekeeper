<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Models\Prompt\RewardChoiceGroup;
use App\Services\RewardChoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RewardChoiceController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Admin / Prompt Controller
    |--------------------------------------------------------------------------
    |
    | Handles creation/editing of prompt categories and prompts.
    |
    */

    /**
     * Shows the choice group index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex() {
        return view('admin.prompts.reward_choice_groups', [
            'groups' => RewardChoiceGroup::get(),
        ]);
    }
    /**
     * Shows the create reward choice group page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreateRewardChoice() {
        return view('admin.prompts.create_edit_reward_choice', [
            'group' => new RewardChoiceGroup,
        ]);
    }

    /**
     * Shows the edit prompt reward choice group page.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEditRewardChoice($id) {
        $group = RewardChoiceGroup::find($id);
        if (!$group) {
            abort(404);
        }

        return view('admin.prompts.create_edit_reward_choice', [
            'group' => $group,
        ]);
    }

    /**
     * Creates or edits a reward choice group.
     *
     * @param App\Services\RewardChoiceService $service
     * @param int|null                   $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateEditRewardChoice(Request $request, RewardChoiceService $service, $id = null) {
        $id ? $request->validate(RewardChoiceGroup::$updateRules) : $request->validate(RewardChoiceGroup::$createRules);
        $data = $request->only([
            'name', 'description', 'rewardable_type', 'rewardable_id', 'quantity',
        ]);
        if ($id && $service->updateRewardChoiceGroup(RewardChoiceGroup::find($id), $data, Auth::user())) {
            flash('Group updated successfully.')->success();
        } elseif (!$id && $group = $service->createRewardChoiceGroup($data, Auth::user())) {
            flash('Group created successfully.')->success();

            return redirect()->to('admin/data/reward-choices/edit/'.$group->id);
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }

    /**
     * Gets the prompt category deletion modal.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getDeletePromptCategory($id) {
        $category = RewardChoiceGroup::find($id);

        return view('admin.prompts._delete_prompt_category', [
            'category' => $category,
        ]);
    }

    /**
     * Deletes a prompt category.
     *
     * @param App\Services\RewardChoiceService $service
     * @param int                        $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeletePromptCategory(Request $request, RewardChoiceService $service, $id) {
        if ($id && $service->deletePromptCategory(RewardChoiceGroup::find($id))) {
            flash('Category deleted successfully.')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->to('admin/data/prompt-categories');
    }    
}