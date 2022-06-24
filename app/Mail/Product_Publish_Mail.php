<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Product_Publish_Mail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $userName;
    public $productName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userName, $productName)
    {
        $this->userName = $userName;
        $this->productName = $productName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('商品上架通知')->view('product_publish_mail');
    }
}
