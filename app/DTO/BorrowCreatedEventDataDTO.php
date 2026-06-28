<?php

namespace App\DTO;

final readonly class BorrowCreatedEventDataDTO
{
    /**
     * @param BorrowedItemDTO[] $borrowedItems
     */
    public function __construct(
        public string $borrow_uuid,
        public string $borrow_start_date,
        public string $borrow_end_date,
        public string $memberCardUuid,
        public string $borrowUuid,
        public string $borrowStartDate,
        public string $borrowEndDate,
        public array  $borrowedItems,
    )
    {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            borrow_uuid: $payload['borrow_uuid'],
            borrow_start_date: $payload['borrow_start_date'],
            borrow_end_date: $payload['borrow_end_date'],
            memberCardUuid: $payload['member_card_uuid'],
            borrowUuid: $payload['borrow_uuid'],
            borrowStartDate: $payload['borrow_start_date'],
            borrowEndDate: $payload['borrow_end_date'],
            borrowedItems: array_map(
                static fn(array $item) => BorrowedItemDTO::fromArray($item),
                $payload['borrowed_items']
            ),
        );
    }
}
