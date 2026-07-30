<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use App\Foundation\Base\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens, ModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'restaurant_id',
        'username',
        'phone',
        'email',
        'cpf',
        'password',
        'gender',
        'birth_date',   
        'avatar',      
        'is_active',
        'last_login_at',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function rolesPermissions(): array
    {
        $permissions = [];
        $this->roles->each(function(Role $role) use (&$permissions) {
            if ($role->loadPermissions->toArray() != []){
                $permissions[] = $role->loadPermissions->toArray();
            }
        });
        return $permissions;
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, "model_id")->where('model', User::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date'    => "date"
        ];
    }

    public function hasPermissionTo($permission, ?string $guardName = null): bool
    {
        $permissionName = is_string($permission) ? $permission : $permission->name;
        $direct = $this->permissions()->where('name', $permissionName)
            ->first();
        if ($direct){
            return (bool)$direct->pivot->granted;
        }
        return $this->hasPermissionViaRole(
            $this->filterPermission($permission, $guardName)
        );
    }

    public function permissions(): BelongsToMany
    {
        return $this->morphToMany(
            config('permission.models.permission'),
            'model',
            config('permission.table_names.model_has_permissions'),
            config('permission.column_names.model_morph_key'),
            config('permission.column_names.permission_pivot_key')
        )->withPivot('granted')->wherePivot('granted', true);
    }

    public function grantedPermissions(string|int $permission, bool $granted)
    {
        $pem = is_string($permission) ? Permission::findByName($permission)->id : $permission;
        $exists = DB::table('model_has_permissions')
            ->where('model_id', $this->id)
            ->where('permission_id', $pem)
            ->where('model_type', User::class)
            ->exists();
        if ($exists){
            DB::table('model_has_permissions')
            ->where('model_id', $this->id)
            ->where('permission_id', $pem)
            ->where('model_type', User::class)
            ->update(['granted' => $granted]);
            return;
        }
        $this->permissions()->syncWithoutDetaching([
            $pem => ['granted'  => $granted]
        ]);
    }

    public function removeAllGranted()
    {
        if($this->hasRole('admin')){
            DB::table('model_has_permissions')
            ->where('model_id', $this->id)
            ->where('model_type', User::class)
            ->delete();
        }
    }

    public function nameInicial(): string
    {
        $name = explode(" ", $this->name);
        if (count($name) == 1) {
            $inicial = $name[0][0]. $name[0][1];
            return strtoupper($inicial);
        }
        $inicial = $name[0][0] . $name[1][0];
        return strtoupper($inicial);
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function(User $user){
            $user->restaurant_id = $user->auth()->id;
        });
    }
}
