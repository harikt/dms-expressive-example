<?php
use App\Seed\SeedInterface;
use Dms\Common\Structure\DateTime\Date;
use Dms\Common\Structure\FileSystem\Image;
use Dms\Package\Blog\Domain\Services\Persistence\IBlogArticleRepository;
use Dms\Package\Blog\Domain\Services\Persistence\IBlogAuthorRepository;
use Dms\Package\Blog\Domain\Services\Persistence\IBlogCategoryRepository;
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
    protected $blogArticleRepo;

    /**
     *
     * @var IBlogAuthorRepository
     */
    protected $blogAuthorRepo;

    /**
     *
     * @var IBlogCategoryRepository
     */
    protected $blogCategory;

    /**
     * @param IBlogArticleRepository $blogArticleRepo
     */
    public function __construct(IBlogArticleRepository $blogArticleRepo, IBlogAuthorRepository $blogAuthorRepo, IBlogCategoryRepository $blogCategory)
    {
        $this->blogArticleRepo = $blogArticleRepo;
        $this->blogAuthorRepo = $blogAuthorRepo;
        $this->blogCategory = $blogCategory;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->blogArticleRepo->clear();
        $this->blogAuthorRepo->clear();
        $this->blogCategory->clear();

        $faker = FakerFactory::create();

        for ($i=0; $i < 30; $i++) {
            $this->blogArticleRepo->save(
                new BlogArticle(
                    new BlogAuthor(
                        $faker->name,
                        $faker->slug,
                        'editor',
                        new Html($faker->realText(200))
                    ),
                    new BlogCategory($faker->name, $faker->slug, true, new DateTimeClock()),
                    $faker->realText(50),
                    $faker->realText(50),
                    $faker->realText(300),
                    $faker->slug,
                    new Image($faker->image(getcwd() . '/public/images', 300, 300, 'cats', true, true, 'Faker')),
                    new Date(2000, 01, 01),
                    new Html($faker->realText(1000)),
                    true,
                    true,
                    true,
                    new DateTimeClock()
                )
            );
        }

    }
}
