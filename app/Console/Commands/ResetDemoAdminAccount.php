<?php namespace App\Console\Commands;

use DB;
use Hash;
use App\User;
use App\Playlist;
use Illuminate\Console\Command;

class ResetDemoAdminAccount extends Command {

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'demo:reset';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Reset admin account';

    /**
     * @var User
     */
    private $user;

    /**
     * @var Playlist
     */
    private $playlist;

    /**
     * ResetDemoAdminAccount constructor.
     *
     * @param User $user
     * @param Playlist $playlist
     */
    public function __construct(User $user, Playlist $playlist)
	{
        parent::__construct();

	    $this->user = $user;
        $this->playlist = $playlist;
    }

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$admin = $this->user->where('email', 'admin@admin.com')->firstOrFail();

        $admin->avatar = null;
        $admin->username = null;
        $admin->password = Hash::make('admin');
        $admin->save();

        $admin->tracks()->detach();
        $ids = $admin->playlists()->wherePivot('owner', 1)->select('playlists.id')->pluck('id');

        $this->playlist->whereIn('id', $ids)->delete();
        DB::table('playlist_track')->whereIn('playlist_id', $ids)->delete();
        DB::table('playlist_user')->whereIn('playlist_id', $ids)->delete();

        $this->info('Demo site reset.');
	}
}
