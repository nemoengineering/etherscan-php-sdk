<?php

namespace Nemo\Etherscan\Support;

enum Chain: string
{
    case Ethereum = 'ETHEREUM';
    case Optimism = 'OPTIMISM';
    case Arbitrum = 'ARBITRUM';
    case Polygon = 'POLYGON';
    case GnosisChain = 'GNOSIS_CHAIN';
    case Fantom = 'FANTOM';
    case Avalanche = 'AVALANCHE';
}
