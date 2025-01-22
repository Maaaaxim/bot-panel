<?php

namespace App\Http\Controllers;

use App\Http\Resources\BotUserResource;
use App\Models\BotUser;
use App\Services\BotUsersService;
use App\Services\DiaryApiService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\LinesOfCode\LinesOfCode;

class UsersController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

//    public function index(Request $request, DiaryApiService $diaryApiService): \Illuminate\Http\Resources\Json\ResourceCollection
//    {
//        $perPage = $request->input('per_page', 10);
//        $botId = $request->input('botId');
//
//        $botUsers = BotUser::getPaginatedUsers($perPage, $botId);
//
//        if ($botId->type_id == 6){
//            $result = $diaryApiService->showUsersInfoForBot();
//        }
//
//        return BotUserResource::collection($botUsers);
//    }
    public function index(Request $request, DiaryApiService $diaryApiService)
    {
        $perPage = $request->input('per_page', 10);
        $botId   = $request->input('botId');

        $bot = \App\Models\Bot::find($botId);

        $botUsers = BotUser::getPaginatedUsers($perPage, $botId);

        if ($bot && $bot->type_id == 6) {
            $caloriesIds = $botUsers
                ->pluck('calories_id')
                ->filter()
                ->unique()
                ->values()
                ->toArray();

            if (empty($caloriesIds)) {
                $diaryData = [];
            } else {
                $locale = 'en';
                $bulkData = $diaryApiService->showUsersInfoForBotMultiple($caloriesIds, $locale);

                $diaryData = [];
                if (is_array($bulkData) && !isset($bulkData['error'])) {
                    foreach ($bulkData as $row) {
                        $cid = $row['calories_id'];
                        $diaryData[$cid] = [
                            'email' => $row['email'] ?? null,
                            'name'  => $row['name'] ?? null,
                        ];
                    }
                } else {
                    $diaryData = [];
                }
            }

            return new \App\Http\Resources\CaloriesBotUserResource($botUsers, $diaryData);
        }

        return \App\Http\Resources\BotUserResource::collection($botUsers);
    }


    public function show(BotUser $user): \Illuminate\Http\JsonResponse
    {
        return response()->json($user);
    }

    public function destroy(BotUser $user): \Illuminate\Http\JsonResponse
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function export(Request $request, BotUsersService $botUsersService): \Illuminate\Http\JsonResponse
    {
        $botId = $request->query('botId');
        $content = $botUsersService->exportUsers($botId);

        if (empty($content)) {
            $content = "No users with valid usernames found.";
        }

        $fileName = 'usernames.txt';
        $botUsersService->saveToFile($content, $fileName);

        $downloadUrl = route('file.download', ['filename' => $fileName]);

        return response()->json([
            'message' => 'Export successful',
            'downloadUrl' => $downloadUrl
        ]);
    }
}
