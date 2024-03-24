<?php 

/* =====================================================================
Function receives a PDO connection object as parameter & returns an array of rows
========================================================================*/
function find_by_btitle(\PDO $pdo, string $keyword): array
{
    $pattern = '%' . $keyword . '%';

    $sql = 'SELECT book_id, book_name, price, quantity FROM books WHERE book_name LIKE :pattern';

    $statement = $pdo->prepare($sql);
    $statement->execute([':pattern' => $pattern]);

    return  $statement->fetchAll(PDO::FETCH_ASSOC);
}

function get_books_by_publish_date(\PDO $pdo, int $published_year): array
{
    $sql = 'CALL get_books_published_after(:published_year)';

    $statement = $pdo->prepare($sql);
    $statement->bindParam(':published_year', $published_year, PDO::PARAM_INT);
    $statement->execute();

    return  $statement->fetchAll(PDO::FETCH_ASSOC);
}

?>