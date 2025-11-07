<?php

declare(strict_types=1);

enum Sector: string
{
    case TECHNOLOGY = 'TECHNOLOGY';
    case FINANCE = 'FINANCE';
    case HEALTHCARE = 'HEALTHCARE';
    case ENERGY = 'ENERGY';
}

class StockPrice
{
    public string $date;
    public float $closedPrice;
    public float $openedPrice;
    public float $highestPrice;
    public float $lowestPrice;

    public function __construct(string $date, float $closedPrice, float $openedPrice, float $highestPrice, float $lowestPrice)
    {
        $this->date = $date;
        $this->closedPrice = $closedPrice;
        $this->openedPrice = $openedPrice;
        $this->highestPrice = $highestPrice;
        $this->lowestPrice = $lowestPrice;
    }
}

class Stock
{
    public string $ticker;
    public float $sharesOutstanding;
    public Sector $sector;
    public array $stockPrices = [];

    public function __construct(string $ticker, float $sharesOutstanding, Sector $sector)
    {
        $this->ticker = $ticker;
        $this->sharesOutstanding = $sharesOutstanding;
        $this->sector = $sector;
    }

    public function addStockPrice(StockPrice $stockPrice): void
    {
        $priceDate = $stockPrice->date;
        if (isset($this->stockPrices[$priceDate])) {
            echo "There is already a historical price for this date for this stock\n";
            return;
        }
        $this->stockPrices[$priceDate] = $stockPrice;
    }

    public function calculateMarketCapForDate(string $date): ?float
    {
        if (!isset($this->stockPrices[$date])) {
            echo "No historical price for this date for this stock\n";
            return null;
        }
        return $this->sharesOutstanding * $this->stockPrices[$date]->closedPrice;
    }

    public function getLastClosedPrice(): ?float
    {
        if (empty($this->stockPrices)) {
            return null;
        }
        $lastDate = array_key_last($this->stockPrices);
        if ($lastDate === null) {
            return null;
        }
        return $this->stockPrices[$lastDate]->closedPrice ?? null;
    }
}

class StockExchange
{
    public string $exchangeName;
    public array $listedStocks = [];

    public function __construct(string $exchangeName)
    {
        $this->exchangeName = $exchangeName;
    }

    public function listStock(Stock $stock): void
    {
        $this->listedStocks[$stock->ticker] = $stock;
    }

    public function findStockByTicker(string $ticker): ?Stock
    {
        if (!isset($this->listedStocks[$ticker])) {
            echo "Stock not found\n";
            return null;
        }
        return $this->listedStocks[$ticker];
    }
}

class Portfolio
{
    public float $cashBalance;
    public array $stockHoldings = [];

    public function __construct(float $cashBalance)
    {
        $this->cashBalance = $cashBalance;
    }

    public function buyStock(string $ticker, int $sharesToBuy, StockExchange $exchange): void
    {
        $stock = $exchange->findStockByTicker($ticker);
        if (!$stock) return;

        $lastPrice = $stock->getLastClosedPrice();
        if ($lastPrice === null) {
            echo "No price available for this stock\n";
            return;
        }

        $purchaseCost = $lastPrice * $sharesToBuy;
        if ($this->cashBalance < $purchaseCost) {
            echo "Insufficient cash to buy this stock\n";
            return;
        }

        $this->cashBalance -= $purchaseCost;
        $this->stockHoldings[] = [
            'numberOfShares' => $sharesToBuy,
            'stock' => $stock,
        ];
        echo "Bought {$sharesToBuy} shares of {$ticker} for {$purchaseCost} USD on {$exchange->exchangeName}\n";
    }

    public function sellStock(string $ticker, int $sharesToSell, StockExchange $exchange): void
    {
        $stock = $exchange->findStockByTicker($ticker);
        if (!$stock) return;

        $totalOwnedShares = 0;
        foreach ($this->stockHoldings as $holding) {
            if ($holding['stock']->ticker === $ticker) {
                $totalOwnedShares += (int)$holding['numberOfShares'];
            }
        }
        if ($totalOwnedShares < $sharesToSell) {
            echo "Not enough shares to sell\n";
            return;
        }

        $lastPrice = $stock->getLastClosedPrice();
        if ($lastPrice === null) {
            echo "No price available for this stock\n";
            return;
        }

        $totalRevenue = $lastPrice * $sharesToSell;
        $this->cashBalance += $totalRevenue;

        $remainingShares = $sharesToSell;
        foreach ($this->stockHoldings as $index => $holding) {
            if ($holding['stock']->ticker === $ticker) {
                $ownedShares = (int)$holding['numberOfShares'];
                if ($ownedShares <= $remainingShares) {
                    $remainingShares -= $ownedShares;
                    unset($this->stockHoldings[$index]);
                    if ($remainingShares === 0) break;
                } else {
                    $this->stockHoldings[$index]['numberOfShares'] = $ownedShares - $remainingShares;
                    $remainingShares = 0;
                    break;
                }
            }
        }
        $this->stockHoldings = array_values($this->stockHoldings);
        echo "Sold {$sharesToSell} shares of {$ticker} for {$totalRevenue} USD on {$exchange->exchangeName}\n";
    }
}

$applePrice1 = new StockPrice('01/01/2025', 100.0, 95.0, 102.0, 90.0);
$applePrice2 = new StockPrice('02/01/2025', 110.0, 100.0, 115.0, 98.0);
$applePrice3 = new StockPrice('03/01/2025', 120.0, 112.0, 125.0, 110.0);

$appleStock = new Stock('AAPL', 16000000000.0, Sector::TECHNOLOGY);
$appleStock->addStockPrice($applePrice1);
$appleStock->addStockPrice($applePrice2);
$appleStock->addStockPrice($applePrice3);

$microsoftStock = new Stock('MSFT', 7500000000.0, Sector::TECHNOLOGY);
$microsoftStock->addStockPrice(new StockPrice('01/01/2025', 300.0, 295.0, 310.0, 290.0));

$nasdaq = new StockExchange('NASDAQ');
$nasdaq->listStock($appleStock);
$nasdaq->listStock($microsoftStock);

echo "MarketCap 02/01/2025: " . ($appleStock->calculateMarketCapForDate('02/01/2025') ?? 'null') . " USD\n";

$portfolio = new Portfolio(10000.0);
$portfolio->buyStock('AAPL', 10, $nasdaq);
$portfolio->buyStock('MSFT', 5, $nasdaq);
$portfolio->buyStock('MSFT', 1000, $nasdaq);
$portfolio->sellStock('AAPL', 4, $nasdaq);
$portfolio->sellStock('MSFT', 50, $nasdaq);

echo "Cash: {$portfolio->cashBalance} USD\n";
print_r($portfolio->stockHoldings);
