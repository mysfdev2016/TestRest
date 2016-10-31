<?php

namespace App\ApiBundle\Representation;

use JMS\Serializer\Annotation as Serializer;
use Pagerfanta\Pagerfanta;

/**
 * @Serializer\ExclusionPolicy("ALL")
 * @Serializer\XmlRoot("articles")
 */
class Articles implements RepresentationInterface
{
    /**
     * @Serializer\Expose
     * @Serializer\XmlKeyValuePairs
     */
    private $meta;

    /**
     * @Serializer\Expose
     * @Serializer\Type("array<App\CoreBundle\Entity\Article>")
     * @Serializer\XmlList(inline=true, entry="article")
     * @Serializer\SerializedName("articles")
     */
    private $data;

    public function __construct(PagerFanta $data)
    {
        $this->data = $data;

        $this->addMeta('limit', $data->getMaxPerPage());
        $this->addMeta('current_items', count($data->getCurrentPageResults()));
        $this->addMeta('total_items', $data->getNbResults());
        $this->addMeta('offset', $data->getCurrentPageOffsetStart());
    }

    public function addMeta($key, $value)
    {
        $this->meta[$key] = $value;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getMeta($key)
    {
        return $this->meta[$key];
    }
}
