<?php

namespace App\Mail;

use App\Models\ConsumableApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConsumableApply extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The consumable_application instance.
     *
     * @var \App\Models\ConsumableApplication
     */
    public $consumable_application;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ConsumableApplication $consumable_application)
    {
        $this->consumable_application = $consumable_application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.consumable.apply')->with([
            'url' => config('app.url') . '/dashboard/application/consumable/' . $this->consumable_application->id
        ])->subject('消耗品申请等待审批');
    }
}
