<?php
use App\Seed\SeedInterface;
use Dms\Common\Structure\DateTime\Date;
use Dms\Common\Structure\FileSystem\Image;
use Dms\Package\Blog\Domain\Services\Persistence\IBlogArticleRepository;
use Dms\Package\Blog\Domain\Entities\BlogArticle;
use Dms\Package\Blog\Domain\Entities\BlogAuthor;
use Dms\Package\Blog\Domain\Entities\BlogCategory;
use Dms\Common\Structure\Web\Html;
use Dms\Core\Util\DateTimeClock;
use Faker\Factory as FakerFactory;

class DmsBlogSeeder implements SeedInterface
{
    /**
     * @var IBlogArticleRepository
     */
    protected $repo;

    /**
     * @param IBlogArticleRepository $repo
     */
    public function __construct(IBlogArticleRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->repo->clear();

        $faker = FakerFactory::create();

        for ($i=0; $i < 10; $i++) {
            $this->repo->save(
                new BlogArticle(
                    new BlogAuthor(
                        $faker->name,
                        $faker->slug,
                        'editor',
                        new Html($faker->realText(200))
                    ),
                    new BlogCategory($faker->name, $faker->slug, true, new DateTimeClock()),
                    $faker->text(50),
                    $faker->text(50),
                    $faker->paragraph(3),
                    $faker->slug,
                    new Image($faker->image(getcwd() . '/public/images', 300, 300, 'cats', true, true, 'Faker')),
                    new Date(2000, 01, 01),
                    new Html($faker->paragraph(3)),
                    true,
                    true,
                    true,
                    new DateTimeClock()
                )
            );
        }

    }
}
