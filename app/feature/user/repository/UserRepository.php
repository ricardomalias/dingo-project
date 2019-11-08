<?php


namespace App\feature\user\repository;


use App\feature\user\model\User;
use App\feature\user\model\UserCompany;
use Core\Repository\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{
    protected $model = User::class;

    public function getUser($id_user)
    {
        $model = new $this->model();

        $user = $model->where([
                'user_id' => $id_user
            ])
            ->first();

        $user_companies = $user
            ->company()
            ->get()
            ->makeHidden('laravel_through_key')
            ->toArray();

        $user = $user->toArray();
        $user['companies'] = $user_companies;

        return $user;
    }

    public function saveUser(array $values)
    {
        $user_model = new $this->model();
        $user_model->name = $values['name'];
        $user_model->email = $values['email'];
        $user_model->password = $values['password'];

        if($user_model->save())
        {
            $user_id = $user_model->user_id;

            $user_company = new UserCompany();
            $user_company->user_id = $user_id;
            $user_company->company_id = $values['company_id'];

            $user_model->userCompany()->save($user_company);

            return $user_id;
        }

        return null;
    }
}