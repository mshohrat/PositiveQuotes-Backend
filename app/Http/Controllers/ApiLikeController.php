<?php

namespace App\Http\Controllers;

use App\Http\Utils\ResponseUtil;
use App\LikeQuote;
use App\Quote;
use Illuminate\Http\Request;
use Matrix\Exception;

class ApiLikeController extends Controller
{
    //
    public function getLikes(Request $request) {
        $pageNumber = $request->route('page',1);
        $limit = 15;
        $skipCount = $limit * ($pageNumber - 1);
        $likes = $request->user()->likedQuotes();
        return ResponseUtil::handleResponse([
            'data' => $likes->orderBy('created_at', 'asc')->skip($skipCount)->take($limit)->get(),
            'current_page' => $pageNumber,
            'total_pages' => ((int)($likes->count() / $limit)) + 1
        ],ResponseUtil::SUCCESS);
    }

    public function like(Request $request) {
        $quoteId = $request->route('id');
        if(Quote::find($quoteId)->first() != null) {
            $likes = $request->user()->likedQuotes();
            $likeIds = $likes->pluck('quotes.id')->get();
            if (in_array($quoteId, $likeIds)) {
                return ResponseUtil::handleMessageResponse('The quote is already liked by user', ResponseUtil::SUCCESS);
            } else {
                $likes->attach([$quoteId]);
                return ResponseUtil::handleMessageResponse("The quote liked by user successfully", ResponseUtil::SUCCESS);
            }
        } else {
            return ResponseUtil::handleMessageResponse("The quote not exists",ResponseUtil::NOT_FOUND);
        }
//        $quote = Quote::find($quoteId)->first();
//        if($quote != null) {
//            $oldLike = LikeQuote::where('quote_id',$quote->id)->where('user_id',$request->user()->id)->first();
//            if($oldLike == null)
//            {
//                $newLike = new LikeQuote([
//                    'user_id' => $request->user()->id,
//                    'quote_id' => $quote->id,
//                ]);
//                $newLike->save();
//                return ResponseUtil::handleMessageResponse("The quote liked by user successfully",ResponseUtil::SUCCESS);
//            }
//            else
//            {
//                return ResponseUtil::handleMessageResponse('The quote is already liked by user',ResponseUtil::SUCCESS);
//            }
//        }
//        else
//        {
//            return ResponseUtil::handleMessageResponse("The quote not exists",ResponseUtil::NOT_FOUND);
//        }
    }

    public function dislike(Request $request) {
        $quoteId = $request->route('id');
        if(Quote::find($quoteId)->first() != null) {
            $likes = $request->user()->likedQuotes();
            $likeIds = $likes->pluck('quotes.id')->get();
            if (in_array($quoteId, $likeIds)) {
                $likes->detach([$quoteId]);
                return ResponseUtil::handleMessageResponse("he quote removed from user likes successfully", ResponseUtil::SUCCESS);
            } else {
                return ResponseUtil::handleMessageResponse('The quote is not liked by user', ResponseUtil::SUCCESS);
            }
        } else {
            return ResponseUtil::handleMessageResponse("The quote not exists",ResponseUtil::NOT_FOUND);
        }
//        $quoteId = $request->route('id');
//        $quote = Quote::find($quoteId)->first();
//        if($quote != null) {
//            $oldLike = LikeQuote::where('quote_id',$quote->id)->where('user_id',$request->user()->id)->first();
//            if($oldLike == null)
//            {
//                return ResponseUtil::handleMessageResponse('The quote is not liked by user',ResponseUtil::SUCCESS);
//            }
//            else
//            {
//                $oldLike->forceDelete();
//                return ResponseUtil::handleMessageResponse("The quote removed from user likes successfully",ResponseUtil::SUCCESS);
//            }
//        }
//        else
//        {
//            return ResponseUtil::handleMessageResponse("The quote not exists",ResponseUtil::NOT_FOUND);
//        }
    }

    public function syncOfflineLikes(Request $request) {
        $result = array();
        if($request->has('actions'))
        {
            $actions = $request->get('actions');
            if($actions != null) {
                $likes = $request->user()->likedQuotes();
                $likeIds = $likes->pluck('quotes.id')->get();
                foreach ($actions as $action) {
                    $quote = Quote::find($action['id'])->first();
                    if($quote != null) {
                        if($action['liked'] == true) {
                            if (!in_array($quote->id, $likeIds)) {
                                $likes->attach([$quote->id]);
                            }
                            $result[] = [
                                'id' => $quote->id,
                                'liked' => true
                            ];
                        }
                        else {
                            if (in_array($quote->id, $likeIds)) {
                                $likes->detach([$quote->id]);
                            }
                            $result[] = [
                                'id' => $quote->id,
                                'liked' => false
                            ];
                        }

//                        if($action['liked'] == true) {
//                            $oldLike = LikeQuote::where('quote_id',$quote->id)->where('user_id',$request->user()->id)->first();
//                            if($oldLike == null) {
//                                $newLike = new LikeQuote([
//                                    'user_id' => $request->user()->id,
//                                    'quote_id' => $quote->id,
//                                ]);
//                                $changed = $newLike->save();
//                                if($changed) {
//                                    $result[] = [
//                                        'id' => $quote->id,
//                                        'liked' => true
//                                    ];
//                                }
//                            }
//                        }
//                        else {
//                            $oldLike = LikeQuote::where('quote_id',$quote->id)->where('user_id',$request->user()->id)->first();
//                            if($oldLike != null) {
//                                $changed = $oldLike->forceDelete();
//                                if($changed) {
//                                    $result[] = [
//                                        'id' => $quote->id,
//                                        'liked' => false
//                                    ];
//                                }
//                            }
//                        }
                    }
                }
            }
        }
        return ResponseUtil::handleResponse(['actions_synced'=>$result],ResponseUtil::SUCCESS);
    }
}
