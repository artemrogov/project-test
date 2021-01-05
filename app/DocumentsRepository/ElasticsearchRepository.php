<?php


namespace App\DocumentsRepository;

use App\Contracts\DocumentInterface;
use App\Models\Document;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ElasticsearchRepository implements DocumentInterface
{

    private $elasticsearch;

    /**
     * ElasticsearchRepository constructor.
     * @param $elasticsearch
     */
    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(string $query = ''): Collection
    {
        $items = $this->searchOnElasticsearch($query);
        return $this->buildCollection($items);
    }

    public function getDocumentsList(): Collection
    {
        return Document::documentsPublishDeferred()->get();
    }

    private function searchOnElasticsearch(string $query = ''):array
    {
        $model = new Document();
        return $this->elasticsearch->search([
                    'index'=>$model->getSearchIndex(),
                    'type'=>$model->getSearchType(),
                    'body'=>[
                        'query'=>[
                            'multi_match'=>[
                                'fields'=>['title^5','content'],
                                'query'=>$query
                            ],
                        ],
                    ],
                ]);
    }


    private function buildCollection(array $items) : Collection
    {
        $ids = Arr::pluck($items['hits']['hits'],'_id');

        return Document::findMany($ids)
            ->sortBy(function($document) use ($ids){
               return array_search($document->getKey(),$ids);
            });
    }
}
