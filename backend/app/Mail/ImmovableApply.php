<?php

namespace App\Mail;

use App\Models\ImmovableApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ImmovableApply extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The immovable_application instance.
     *
     * @var \App\Models\ImmovableApplication
     */
    public $immovable_application;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ImmovableApplication $immovable_application)
    {
        $this->immovable_application = $immovable_application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.immovable.apply')->with([
            'url' => config('app.url') . '/dashboard/application/immovable/' . $this->immovable_application->id
        ])->subject('不动产申请等待审批');
    }
}
