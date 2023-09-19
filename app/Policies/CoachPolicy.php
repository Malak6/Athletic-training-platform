namespace App\Policies;

use App\Models\Coach;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoachPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Coach $coach)
    {
        return $user->id === $coach->user_id;
    }
}
