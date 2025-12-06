<?php
ob_start();
?>
<div class="px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Create Trade Plan</h1>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="/plans" method="POST" class="space-y-8">
                <!-- Trading Setup Section -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Trading Setup</h2>
                    <div class="mb-4">
                        <select name="setup_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="">Select a setup...</option>
                            <?php foreach ($setups as $setup): ?>
                            <option value="<?= $setup['id'] ?>"><?= htmlspecialchars($setup['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Trade Details Section -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Trade Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Symbol</label>
                            <input type="text" name="symbol" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                   placeholder="e.g., AAPL">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Sector</label>
                            <select name="sector" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                <option value="">Select Sector</option>
                                <option value="Technology">Technology</option>
                                <option value="Financials">Financials</option>
                                <option value="Healthcare">Healthcare</option>
                                <option value="Consumer Cyclical">Consumer Cyclical</option>
                                <option value="Industrials">Industrials</option>
                                <option value="Energy">Energy</option>
                                <option value="Utilities">Utilities</option>
                                <option value="Communication">Communication</option>
                                <option value="Consumer Defensive">Consumer Defensive</option>
                                <option value="Basic Materials">Basic Materials</option>
                                <option value="Real Estate">Real Estate</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Industry</label>
                            <select name="industry" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                <option value="">Select Industry</option>
                                <option value="Software">Software</option>
                                <option value="Semiconductors">Semiconductors</option>
                                <option value="Banks">Banks</option>
                                <option value="Pharmaceuticals">Pharmaceuticals</option>
                                <option value="Automobiles">Automobiles</option>
                                <option value="Oil & Gas">Oil & Gas</option>
                                <option value="Telecom">Telecom</option>
                                <option value="Retail">Retail</option>
                                <option value="Manufacturing">Manufacturing</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Direction</label>
                            <select name="direction" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                <option value="long">Long</option>
                                <option value="short">Short</option>
                            </select>
                        </div>
                        <input type="hidden" name="trade_date" value="<?= date('Y-m-d H:i:s') ?>">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Timeframe</label>
                                <select name="timeframe" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                    <option value="1m">1m</option>
                                    <option value="5m">5m</option>
                                    <option value="15m">15m</option>
                                    <option value="1h">1h</option>
                                    <option value="4h">4h</option>
                                    <option value="1d">1d</option>
                                    <option value="1w">1w</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Entry TF</label>
                                <select name="entry_timeframe" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                    <option value="1m">1m</option>
                                    <option value="5m">5m</option>
                                    <option value="15m">15m</option>
                                    <option value="1h">1h</option>
                                    <option value="4h">4h</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Price Levels Section -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Price Levels</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Entry Price</label>
                            <input type="number" step="0.00001" name="entry_price" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                   placeholder="0.00000">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Stop Loss</label>
                            <input type="number" step="0.00001" name="stop_loss" required
                                   class="w-full px-3 py-2 border border-red-300 bg-red-50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                                   placeholder="0.00000">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Take Profit</label>
                            <input type="number" step="0.00001" name="take_profit" required
                                   class="w-full px-3 py-2 border border-green-300 bg-green-50 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                   placeholder="0.00000">
                        </div>
                    </div>
                </div>

                <!-- Risk Management Section -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Risk Management</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Capital ($)</label>
                                <input type="number" step="0.01" name="capital" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                       placeholder="0.00">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Risk Percentage</label>
                                <select name="risk" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                    <option value="0.5">0.5%</option>
                                    <option value="1" selected>1%</option>
                                    <option value="1.5">1.5%</option>
                                    <option value="2">2%</option>
                                    <option value="2.5">2.5%</option>
                                    <option value="3">3%</option>
                                </select>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-600 text-xs font-semibold uppercase mb-1">Risk/Share</label>
                                    <div class="px-3 py-2 bg-gray-50 rounded border" id="riskPerShare">₹0.00</div>
                                </div>
                                <div>
                                    <label class="block text-gray-600 text-xs font-semibold uppercase mb-1">Risk/Trade</label>
                                    <div class="px-3 py-2 bg-gray-50 rounded border" id="riskPerTrade">₹0.00</div>
                                </div>
                                <div>
                                    <label class="block text-gray-600 text-xs font-semibold uppercase mb-1">Position Size</label>
                                    <div class="px-3 py-2 bg-gray-50 rounded border" id="positionSizeDisplay">0</div>
                                </div>
                                <div>
                                    <label class="block text-gray-600 text-xs font-semibold uppercase mb-1">Risk:Reward</label>
                                    <div class="px-3 py-2 bg-white rounded border" id="riskRewardRatio">0.00</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Market Context Section -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Market Context</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Market Trend</label>
                            <select name="trend" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                <option value="strong_uptrend">Strong Uptrend</option>
                                <option value="weak_uptrend">Weak Uptrend</option>
                                <option value="ranging">Ranging</option>
                                <option value="weak_downtrend">Weak Downtrend</option>
                                <option value="strong_downtrend">Strong Downtrend</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Trader Emotion</label>
                            <select name="emotion" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                <option value="confident">Confident</option>
                                <option value="optimistic">Optimistic</option>
                                <option value="neutral">Neutral</option>
                                <option value="anxious">Anxious</option>
                                <option value="fearful">Fearful</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Confidence Level</label>
                            <div class="flex items-center space-x-2">
                                <input type="range" name="confidence" min="1" max="10" value="5" required
                                       class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                                       id="confidenceRange">
                                <span id="confidenceValue" class="w-8 text-center font-bold">5</span>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Get all input fields that affect calculations
                    const entryPriceInput = document.querySelector('input[name="entry_price"]');
                    const stopLossInput = document.querySelector('input[name="stop_loss"]');
                    const takeProfitInput = document.querySelector('input[name="take_profit"]');
                    const capitalInput = document.querySelector('input[name="capital"]');
                    const riskPercentInput = document.querySelector('select[name="risk"]');
                    const confidenceRange = document.getElementById('confidenceRange');
                    const confidenceValue = document.getElementById('confidenceValue');
                    
                    // Get all display elements
                    const riskPerShareEl = document.getElementById('riskPerShare');
                    const riskPerTradeEl = document.getElementById('riskPerTrade');
                    const positionSizeEl = document.getElementById('positionSizeDisplay');
                    const riskRewardEl = document.getElementById('riskRewardRatio');
                    
                    // Add event listeners to all relevant inputs
                    [entryPriceInput, stopLossInput, takeProfitInput, capitalInput, riskPercentInput].forEach(input => {
                        input.addEventListener('input', calculateValues);
                    });
                    
                    // Update confidence value display
                    confidenceRange.addEventListener('input', function() {
                        confidenceValue.textContent = this.value;
                    });
                    
                    function calculateValues() {
                        // Get values from inputs
                        const entryPrice = parseFloat(entryPriceInput.value) || 0;
                        const stopLoss = parseFloat(stopLossInput.value) || 0;
                        const takeProfit = parseFloat(takeProfitInput.value) || 0;
                        const capital = parseFloat(capitalInput.value) || 0;
                        const riskPercent = parseFloat(riskPercentInput.value) || 0;
                        
                        // Calculate risk per share (absolute difference between entry and stop loss)
                        const riskPerShare = Math.abs(entryPrice - stopLoss);
                        
                        // Calculate risk per trade (capital * risk%)
                        const riskPerTrade = (capital * riskPercent) / 100;
                        
                        // Calculate position size (risk per trade / risk per share)
                        const positionSize = riskPerShare > 0 ? Math.floor(riskPerTrade / riskPerShare) : 0;
                        
                        // Calculate risk:reward ratio
                        const reward = Math.abs(takeProfit - entryPrice);
                        const riskReward = riskPerShare > 0 ? (reward / riskPerShare).toFixed(2) : '0.00';
                        
                        // Update display values with proper formatting
                        riskPerShareEl.textContent = `₹${riskPerShare.toFixed(5)}`;
                        riskPerTradeEl.textContent = `₹${riskPerTrade.toFixed(2)}`;
                        positionSizeEl.textContent = positionSize.toLocaleString();
                        riskRewardEl.textContent = `1:${riskReward}`;
                        
                        // Visual feedback for risk levels
                        updateRiskVisuals(riskReward);
                    }
                    
                    function updateRiskVisuals(riskReward) {
                        const rr = parseFloat(riskReward);
                        const riskRewardEl = document.getElementById('riskRewardRatio');
                        
                        // Reset classes
                        riskRewardEl.className = 'px-3 py-2 bg-white rounded border';
                        
                        // Add appropriate color based on risk:reward ratio
                        if (rr >= 2) {
                            riskRewardEl.classList.add('text-green-600', 'font-bold');
                        } else if (rr >= 1) {
                            riskRewardEl.classList.add('text-yellow-600', 'font-medium');
                        } else {
                            riskRewardEl.classList.add('text-red-600', 'font-medium');
                        }
                    }
                    
                    // Initial calculation on page load
                    calculateValues();
                });
                </script>
                
                <!-- Notes Section -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Trade Notes & Analysis</h2>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Trade Plan & Rationale</label>
                        <textarea name="notes" rows="5"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                  placeholder="Describe your trade setup, entry/exit strategy, and any additional notes..."></textarea>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg">
                        Create Plan
                    </button>
                    <a href="/plans" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Journal';
require __DIR__ . '/../layout/layout.php';
?>