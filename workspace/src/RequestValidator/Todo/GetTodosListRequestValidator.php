<?php

namespace App\RequestValidator\Todo;

use App\Exception\ValidationErrorException;
use App\RequestValidator\AbstractRequestValidator;
use Symfony\Component\Validator\Constraints as Assert;

class GetTodosListRequestValidator extends AbstractRequestValidator
{
    public function rules(): Assert\Collection
    {
        return new Assert\Collection(
            [
                'page' => new Assert\Optional([
                    new Assert\Type('integer'),
                    new Assert\GreaterThan(0),
                ]),
                'limit' => new Assert\Optional([
                    new Assert\Type('integer'),
                    new Assert\GreaterThan(0),
                    new Assert\LessThanOrEqual(100),
                ]),
            ]
        );
    }

    /**
     * @throws ValidationErrorException
     */
    public function validateFields(): array
    {
        if (!$request = $this->request) {
            return [];
        }

        $inputs = [
            'page' => $request->query->getInt('page', 1),
            'limit' => $request->query->getInt('limit', 10),
        ];

        return $this->doValidate($inputs);
    }
}