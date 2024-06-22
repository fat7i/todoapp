<?php

namespace App\RequestValidator\Todo;

use App\Enum\StatusEnum;
use App\Exception\ValidationErrorException;
use App\RequestValidator\AbstractRequestValidator;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateTodoRequestValidator extends AbstractRequestValidator
{
    public function rules(): Assert\Collection
    {
        return new Assert\Collection(
            [
                'id' => new Assert\Required([
                    new Assert\Type('integer'),
                    new Assert\GreaterThan(0),
                ]),
                'title' => new Assert\Required([
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                    new Assert\Length(['min' => 3, 'max' => 255]),
                ]),
                'description' => new Assert\Optional([
                    new Assert\Type('string'),
                ]),
                'status' => new Assert\Required([
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                    new Assert\Choice(
                        StatusEnum::toArray(),
                        message: 'Invalid status. Valid values are: ' . implode(', ', StatusEnum::toArray()),
                    ),
                ]),
            ]
        );
    }

    /**
     * @throws ValidationErrorException
     */
    public function validateFields(): array
    {
        if (!$request = $this->request->toArray()) {
            return [];
        }

        $inputs = [
            'id' => (int) $this->request->get('id', 0),
            'title' => $request['title'],
            'description' => $request['description'] ?? null,
            'status' => $request['status'],
        ];

        return $this->doValidate($inputs);
    }
}