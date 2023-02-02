<?php

namespace App\Repositories;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;

class MemberRepository
{
  public function store(Request $request)
  {
    $user = User::create($request->all());
    $user->assignRole('Member');
    request()->user()->investor->members()->create([
      'user_id' => $user->id
    ]);
  }

  public function update(Request $request, Member $member)
  {
    if ($request->type == "infos") {
      $member->user->update($request->all('name', 'email'));
    } elseif ($request->type == "password") {
      $member->user->update([
        'password' => bcrypt($request->password)
      ]);
    }
  }
}
