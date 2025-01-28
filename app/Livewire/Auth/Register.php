<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User; // Updated to use User model

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    
    /**
     * rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'], // Updated table name
            'password' => ['required', 'confirmed'],
        ];
    }
    
    /**
     * register
     *
     * @return void
     */
    public function register()
    {
        //validate
        $this->validate();

        //create user
        User::create([ // Updated to use User model
            'name'      => $this->name,
            'email'     => $this->email,
            'password'  => bcrypt($this->password),
        ]);

        //session flash
        session()->flash('success', 'Register Berhasil, silahkan login');

        //redirect
        return $this->redirect('/login', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
