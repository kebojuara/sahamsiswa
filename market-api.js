document.addEventListener('DOMContentLoaded', () => {
    const updateMarketData = async () => {
        try {
            const btcRes = await fetch('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=usd,idr&include_24hr_change=true');
            const btcData = await btcRes.json();
            
            const btcPrice = btcData.bitcoin.usd;
            const btcChange = btcData.bitcoin.usd_24h_change;
            
            updateUI('btc', btcPrice, btcChange, '$');

            const bbcaRes = await fetch('https://query1.finance.yahoo.com/v8/finance/chart/BBCA.JK?interval=1d');
            const bbcaData = await bbcaRes.json();
            const bbcaMeta = bbcaData.chart.result[0].meta;
            const bbcaPrice = bbcaMeta.regularMarketPrice;
            const bbcaPrev = bbcaMeta.chartPreviousClose;
            const bbcaChange = ((bbcaPrice - bbcaPrev) / bbcaPrev) * 100;

            updateUI('bbca', bbcaPrice, bbcaChange, 'Rp');

            const tslaRes = await fetch('https://query1.finance.yahoo.com/v8/finance/chart/TSLA?interval=1d');
            const tslaData = await tslaRes.json();
            const tslaMeta = tslaData.chart.result[0].meta;
            const tslaPrice = tslaMeta.regularMarketPrice;
            const tslaPrev = tslaMeta.chartPreviousClose;
            const tslaChange = ((tslaPrice - tslaPrev) / tslaPrev) * 100;

            updateUI('tsla', tslaPrice, tslaChange, '$');

        } catch (error) {
            console.error(error);
        }
    };

    const updateUI = (ticker, price, change, currency) => {
        const priceEl = document.getElementById(`price-${ticker}`);
        const changeEl = document.getElementById(`change-${ticker}`);
        
        if (priceEl && changeEl) {
            priceEl.innerText = `${currency} ${price.toLocaleString()}`;
            
            const isPositive = change >= 0;
            const sign = isPositive ? '+' : '';
            changeEl.innerText = `${sign}${change.toFixed(2)}%`;
            
            changeEl.className = 'change';
            changeEl.classList.add(isPositive ? 'up' : 'down');
        }
    }

    updateMarketData();
});