<?php

namespace Tests\Feature;

use Livewire\Livewire;
use App\Http\Livewire\ContactForm;
use App\Mail\ContactFormMailable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function main_page_contains_contact_form_livewire_component()
    {
        $this->get('/')
        ->assertSeeLivewire('contact-form');
    }

    /** @test */
    public function contact_form_sends_out_an_email(){
  
        Mail::fake();


         Livewire::test(ContactForm::class)
            ->set('name', 'Andre')
            ->set('email', 'someguy@someguy.com')
            ->set('phone', '12345')
            ->set('message', 'This is my message.')
            ->call('submitForm')
            ->assertSee('We received your message successfully and will get back to you shortly!');
            
        Mail::assertSent(function (ContactFormMailable $mail){
            $mail->build();

            return $mail->hasTo('adityapratamabadra@gmail.com') &&
                    $mail->hasFrom('entahsiapa@mail.com') &&
                    $mail->subject === 'Contact Form Submission';
        });

    }

   /** @test */
    public function contact_form_name_field_is_required(){
        Livewire::test(ContactForm::class)
            ->set('email','someguy@gmail.com')
            ->set('phone','123456')
            ->set('message','This is my message')
            ->call('submitForm')
            ->assertHasErrors(['name' =>'required']);
    }

    /** @test */
    public function contact_form_email_field_is_required(){
        Livewire::test(ContactForm::class)
            ->set('name','Aditya Pratama')
            ->set('phone','123456')
            ->set('message','This is my message')
            ->call('submitForm')
            ->assertHasErrors(['email' =>'required']);
    }

    /** @test */
    public function contact_form_email_field_fails_on_invalid_email(){
        Livewire::test(ContactForm::class)
            ->set('name','Aditya Pratama')
            ->set('email','notanemail')
            ->set('phone','123456')
            ->set('message','This is my message')
            ->call('submitForm')
            ->assertHasErrors(['email' =>'email']);
    }

    /** @test */
    public function contact_form_phone_field_is_required(){
        Livewire::test(ContactForm::class)
            ->set('name','Aditya Pratama')
            ->set('email','someguy@mail.com')
            ->set('message','This is my message')
            ->call('submitForm')
            ->assertHasErrors(['phone' =>'required']);
    }

    /** @test */
    public function contact_form_message_field_is_required(){
        Livewire::test(ContactForm::class)
            ->set('name','Aditya Pratama')
            ->set('email','someguy@mail.com')
            ->set('phone','123456')
            ->call('submitForm')
            ->assertHasErrors(['message' =>'required']);
    }

    /** @test */
    public function contact_form_message_field_has_minimum_characters(){
        Livewire::test(ContactForm::class)
        ->set('message','abc')
        ->call('submitForm')
        ->assertHasErrors(['message' =>'min']);
    }
}
