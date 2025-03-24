<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class FeedbackManagementController extends Controller
{
    public function unresolvedFeedback()
    {

        $itemPerPage = env('ITEM_PER_PAGE', 10);

        $contact = Contact::where('status', 0)->paginate($itemPerPage);

        return view('admin.pages.management_menu.contact-manager-new', compact('contact'));
    }

    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|integer',
        ]);

        $item = Contact::findOrFail($id);
        $item->status = $request->status;
        $item->save();

        return response()->json(["success" => "Trạng thái đã được cập nhật!"]);
    }

    public function responseResolved(){
        $itemPerPage = env('ITEM_PER_PAGE', 10);

        $contact = Contact::where('status', 1)->paginate($itemPerPage);

        return view('admin.pages.management_menu.contact-manager', compact('contact'));
    }
}
