Hello{{$user->name}}
You have changed your email.Please use this link to verify your account.
{{route('verify',$user->verification_token)}}