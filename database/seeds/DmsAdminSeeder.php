<?php
use App\Seed\SeedInterface;
use Dms\Common\Structure\Web\EmailAddress;
use Dms\Core\Auth\IAdminRepository;
use Dms\Web\Expressive\Auth\Password\IPasswordHasherFactory;
use Dms\Web\Expressive\Auth\LocalAdmin;

/**
 * The DMS admin account seeder
 */
class DmsAdminSeeder implements SeedInterface
{
    /**
     * @var IAdminRepository
     */
    protected $repo;

    /**
     * @var IPasswordHasherFactory
     */
    protected $hasherFactory;

    /**
     * DmsUserSeeder constructor.
     *
     * @param IAdminRepository        $repo
     * @param IPasswordHasherFactory $hasherFactory
     */
    public function __construct(IAdminRepository $repo, IPasswordHasherFactory $hasherFactory)
    {
        $this->repo          = $repo;
        $this->hasherFactory = $hasherFactory;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->repo->clear();

        $this->repo->save(new LocalAdmin(
            'Admin',
            new EmailAddress('admin@example.com'),
            'admin',
            $this->hasherFactory->buildDefault()->hash('admin'),
            true // super user
        ));
    }
}
