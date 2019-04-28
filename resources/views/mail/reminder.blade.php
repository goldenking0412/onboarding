@component('mail::message')
  # Reminder

  Hey, we haven't seen you for a while!

  We can't get started on your project until we have all your information. Please log back in to the onboarding platform and continue filling it out. If you have any questions during the process please use the "chat" feature (the blue button)  and a member of the LaunchBoom customer support staff will assist you.

  Once you have everything completed, you will be introduced to your Campaign Strategist who will be your direct point of contact moving forward.


  @component('mail::button', ['url' => url('/')])
    Login
  @endcomponent

  Thanks,<br>
  LaunchBoom Onboarding Team
@endcomponent