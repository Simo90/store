<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Hash;
use App\User;


class ChangePasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change user password';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->getEmail();
        $password = '';

        if ( $email!='' ){
            $password = $this->getPassword();
        }

        if ( $password == '' ){
            die( $this->error('Please add new password!') );
        }

        $user = User::where('email',$email)->update( [
            'password' => bcrypt( $password ),
        ]);

        die( $this->line('Success msg!') );
    }

    /**
     * Ask for user email.
     *
     * @return string
     */
    private function getEmail(): string
    {
        $email = $this->ask('Email');
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die( $this->error('Invalid email format') );
        }
        elseif ( !User::where('email',$email) -> first() ) {
            die( $this->error('Email not found!') );
        }

        return $email;
    }

    /**
     * Ask for new password.
     *
     * @return string
     */
    private function getPassword(): string
    {
        $password = $this->ask('password');
        
        if ( strlen($password) < 6 ) {
            die( $this->error('Very easy password!') );
        }

        return $password;
    }
}
