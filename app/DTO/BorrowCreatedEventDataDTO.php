<?php

namespace App\DTO;

final readonly class BorrowCreatedEventDataDTO
{
    /**
     * @param BorrowedItemDTO[] $borrowedItems
     */
    public function __construct(
        public string $borrowUuid,
        public string $memberCardUuid,
        public string $borrowStartDate,
        public string $borrowEndDate,
        public array  $borrowedItems,
    )
    {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            borrowUuid: $payload['borrow_uuid'],
            memberCardUuid: $payload['member_card_uuid'],
            borrowStartDate: $payload['borrow_start_date'],
            borrowEndDate: $payload['borrow_end_date'],
            borrowedItems: array_map(
                static fn(array $item) => BorrowedItemDTO::fromArray($item),
                $payload['borrowed_items']
            ),
        );
    }
}
