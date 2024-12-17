<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $department_id
 * @property string $department_name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereDepartmentName($value)
 */
	class Department extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $role_id
 * @property string $role_name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereRoleName($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $software_id
 * @property string $f_name
 * @property string $l_name
 * @property int $department_id
 * @property string $tel
 * @property string $software_name
 * @property string $problem
 * @property string $target
 * @property string $purpose
 * @property string $status
 * @property int $approved_by_dh
 * @property int $approved_by_admin
 * @property string|null $file
 * @property string $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software whereApprovedByAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software whereApprovedByDh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software whereFName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software whereLName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software whereProblem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software whereSoftwareId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software whereSoftwareName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Software whereUpdatedAt($value)
 */
	class Software extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $username
 * @property string $f_name
 * @property string $l_name
 * @property string $status
 * @property string $password
 * @property \App\Models\Role $role
 * @property \App\Models\Department $department
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Software> $softwares
 * @property-read int|null $softwares_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

