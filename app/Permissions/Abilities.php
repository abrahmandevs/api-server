<?php

namespace App\Permissions;

use App\Models\User;

final class Abilities {
    public const CreateTicket ='ticket:create';
    public const UpdateTicket ='ticket:update';
    public const ReplaceTicket ='ticket:replace';
    public const DeleteTicket ='ticket:delete';

    public const UpdateOwnTicket ='ticket:Own:update';
    public const DeleteOwnTicket ='ticket:Own:delete';


    public const createUser ='user:create';
    public const UpdateUser ='user:update';
    public const ReplaceUser ='user:replace';
    public const DeleteUser ='user:delete';


    public static function getAbilites(User $user){
        if ($user->in_manager) {
            return[
                self::CreateTicket,
                self::UpdateTicket,
                self::ReplaceTicket,
                self::DeleteTicket,
                self::createUser,
                self::UpdateUser,
                self::ReplaceUser,
                self::DeleteUser,
            ];
        }else{
            return [
                self::CreateTicket,
                self::UpdateOwnTicket,
                self::DeleteOwnTicket,

            ];
        }
    }
}

?>
