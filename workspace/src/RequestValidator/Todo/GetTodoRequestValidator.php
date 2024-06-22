<?php

namespace App\RequestValidator\Todo;

use App\Exception\ValidationErrorException;
use App\RequestValidator\AbstractRequestValidator;
use Symfony\Component\Validator\Constraints as Assert;

class GetTodoRequestValidator extends AbstractRequestValidator
{
    public function rules(): Assert\Collection
    {
        return new Assert\Collection(
            [
                'id' => new Assert\Required([
                    new Assert\Type('integer'),
                    new Assert\GreaterThan(0),
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
            'id' => (int) $request->get('id', 0),
        ];

        return $this->doValidate($inputs);
    }
}