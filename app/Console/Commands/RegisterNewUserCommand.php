<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Hash;
use App\User;

class RegisterNewUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add new user';
    


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
        $details = $this->getDetails();

        if ( is_array($details) ){
            $details['password'] = bcrypt( $details['password'] );
            $user = User::create( $details );
            $this->display( $user );
        }
    }


    /**
     * Ask for user details.
     *
     * @return array
     */
    private function getDetails(): array
    {
        
        $details['name'] = $this->ask('Name');
        $details['email'] = $this->ask('Email');
        $details['password'] = $this->secret('Password');
        $details['confirm_password'] = $this->secret('Confirm password');

        if (! $this->isRequiredLength($details['password'])) {
            die( $this->error('Password must be more that six characters') );
        }
        else if (! $this->isMatch($details['password'], $details['confirm_password'])) {
            die( $this->error('Password and Confirm password do not match') );
        }
        return $details;
    }
    
    
    /**
     * Display created user.
     *
     * @param array $user
     * @return void
     */
    private function display(User $user) : void
    {
        $headers = ['id','Name', 'Email'];
        $fields = [
            'ID' => $user->id,
            'Name' => $user->name,
            'email' => $user->email,
        ];
        $this->info('New user was created!');
        $this->table($headers, [$fields]);
    }


    /**
     * Check if password is vailid
     *
     * @param string $password
     * @param string $confirmPassword
     * @return boolean
     */
    private function isValidPassword(string $password, string $confirmPassword) : bool
    {
        return $this->isRequiredLength($password) &&
        $this->isMatch($password, $confirmPassword);
    }


    /**
     * Check if password and confirm password matches.
     *
     * @param string $password
     * @param string $confirmPassword
     * @return bool
     */
    private function isMatch(string $password, string $confirmPassword) : bool
    {
        return $password === $confirmPassword;
    }

    
    /**
     * Checks if password is longer than six characters.
     *
     * @param string $password
     * @return bool
     */
    private function isRequiredLength(string $password) : bool
    {
        return strlen($password) > 6;
    }
}