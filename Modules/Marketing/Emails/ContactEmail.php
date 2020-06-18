<?php

namespace Modules\Marketing\Emails;

use Plugin\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $name;
    public $email;
    public $subject;
    public $phone;
    public $text;

    public function __construct($data)
    {
        $this->name = $data->marketing_contact_name;
        $this->email = $data->marketing_contact_email;
        $this->subject = $data->marketing_contact_subject;
        $this->phone = $data->marketing_contact_phone;
        $this->text = $data->marketing_contact_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        return $this->view(Helper::setViewEmail('contact', 'Marketing'));
    }
}
