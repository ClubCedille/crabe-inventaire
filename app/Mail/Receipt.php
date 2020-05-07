<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Receipt extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $products;
    protected $total;
    protected $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $products, $total, $date)
    {
        $this->name = $name;
        $this->products = $products;
        $this->total = $total;
        $this->date = $date;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('crabe@gmail.com')
                    ->markdown('emails.receipt')
                    ->with([
                        'name' => $this->name,
                        'products' => $this->products,
                        'total' => $this->total,
                        'date' => $this->date,
                    ]);
    }
}
