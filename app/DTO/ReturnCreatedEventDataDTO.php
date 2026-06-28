<?php

namespace App\DTO;

final readonly class ReturnCreatedEventDataDTO
{
    /**
     * @param BorrowedItemDTO[] $borrowedItems
     */
    public function __construct(
        public string $memberCardUuid,
        public string $borrowUuid,
        public string $borrowStartDate,
        public string $borrowEndDate,
        public string $borrowReturnDate,
        public bool   $returnLately,
        public int    $daysLate,
        public int    $lateFee,
        public array  $borrowedItems,
    )
    {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            memberCardUuid: $payload['member_card_uuid'],
            borrowUuid: $payload['borrow_uuid'],
            borrowStartDate: $payload['borrow_start_date'],
            borrowEndDate: $payload['borrow_end_date'],
            borrowReturnDate: $payload['borrow_return_date'],
            returnLately: $payload['return_lately'],
            daysLate: $payload['days_late'],
            lateFee: $payload['late_fee'],
            borrowedItems: array_map(
                static fn(array $item) => BorrowedItemDTO::fromArray($item),
                $payload['returned_items']
            ),
        );
    }
}
