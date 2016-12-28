<?php
namespace AppBundle\Service\Paginator;

use Doctrine\ORM\Query;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class Paginator
{
    private const PAGE_DEFAULT = 1;
    public const LIMIT_DEFAULT = 10;

    /** @var PaginatorInterface */
    private $paginator;
    /** @var RequestStack */
    private $requestStack;

    /**
     * @param PaginatorInterface $paginator
     * @param RequestStack       $requestStack
     */
    public function __construct(PaginatorInterface $paginator, RequestStack $requestStack)
    {
        $this->paginator = $paginator;
        $this->requestStack = $requestStack;
    }

    /**
     * @param Query $query
     * @param int   $limit
     * @param array $options
     * @return PaginationInterface
     */
    public function paginate(Query $query, int $limit = self::LIMIT_DEFAULT, array $options = []): PaginationInterface
    {
        return $this->paginator->paginate($query, $this->getCurrentPage(), $limit, $options);
    }

    /**
     * @return int
     */
    private function getCurrentPage(): int
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request instanceof  Request) {
            return $request->query->getInt('p', static::PAGE_DEFAULT);
        }

        return static::PAGE_DEFAULT;
    }
}
