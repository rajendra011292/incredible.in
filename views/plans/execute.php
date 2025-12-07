<?php
ob_start();
?>
<div class="px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Execute Trade Plan</h1>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="/plans/<?= $plan['id'] ?>/execute" method="POST" class="space-y-8">
                <!-- Trading Setup & Details Section -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Trading Setup & Details</h2>
                    <div class="space-y-4">
                        <!-- Setup Selection -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Trading Setup</label>
                            <div class="px-3 py-2 bg-gray-50 rounded-lg border border-gray-200">
                                <?php 
                                $selectedSetup = '';
                                foreach ($setups as $setup) {
                                    if ($plan['setup_id'] == $setup['id']) {
                                        $selectedSetup = htmlspecialchars($setup['name']);
                                        break;
                                    }
                                }
                                echo $selectedSetup ?: 'No setup selected';
                                ?>
                                <input type="hidden" name="setup_id" value="<?= $plan['setup_id'] ?>">
                            </div>
                        </div>

                        <!-- Trade Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Symbol</label>
                            <div class="px-3 py-2 bg-gray-50 rounded-lg border border-gray-200">
                                <?= htmlspecialchars($plan['symbol']) ?: 'N/A' ?>
                                <input type="hidden" name="symbol" value="<?= htmlspecialchars($plan['symbol']) ?>">
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Sector</label>
                            <div class="px-3 py-2 bg-gray-50 rounded-lg border border-gray-200">
                                <?= htmlspecialchars($plan['sector']) ?: 'N/A' ?>
                                <input type="hidden" name="sector" value="<?= htmlspecialchars($plan['sector']) ?>">
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Industry</label>
                            <div class="px-3 py-2 bg-gray-50 rounded-lg border border-gray-200">
                                <?= htmlspecialchars($plan['industry']) ?: 'N/A' ?>
                                <input type="hidden" name="industry" value="<?= htmlspecialchars($plan['industry']) ?>">
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Direction</label>
                            <div class="px-3 py-2 bg-gray-50 rounded-lg border border-gray-200">
                                <?= ucfirst(htmlspecialchars($plan['direction'])) ?: 'N/A' ?>
                                <input type="hidden" name="direction" value="<?= $plan['direction'] ?>">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Timeframe</label>
                                <div class="px-3 py-2 bg-gray-50 rounded-lg border border-gray-200">
                                    <?= htmlspecialchars($plan['timeframe']) ?: 'N/A' ?>
                                    <input type="hidden" name="timeframe" value="<?= $plan['timeframe'] ?>">
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Entry TF</label>
                                <div class="px-3 py-2 bg-gray-50 rounded-lg border border-gray-200">
                                    <?= htmlspecialchars($plan['entry_timeframe']) ?: 'N/A' ?>
                                    <input type="hidden" name="entry_timeframe" value="<?= $plan['entry_timeframe'] ?>">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="trade_date" value="<?= date('Y-m-d H:i:s') ?>">
                    </div>
                </div>

                        </div><!-- End of Trade Details Grid -->
                    </div>
                </div>

                <!-- Price Levels Section -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Price Levels</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Entry Price</label>
                            <input type="number" step="0.00001" name="entry_price" required value="<?= $plan['entry_price'] ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                   placeholder="0.00000">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Stop Loss</label>
                            <input type="number" step="0.00001" name="stop_loss" required value="<?= $plan['stop_loss'] ?>"
                                   class="w-full px-3 py-2 border border-red-300 bg-red-50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                                   placeholder="0.00000">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Take Profit</label>
                            <input type="number" step="0.00001" name="take_profit" required value="<?= $plan['take_profit'] ?>"
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
                                <input type="number" step="0.01" name="capital" required value="<?= $plan['capital'] ?>" readonly
                                       class="w-full px-3 py-2 border border-gray-300 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                       placeholder="0.00">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Risk Percentage</label>
                                <select name="risk" required disabled
                                        class="w-full px-3 py-2 border border-gray-300 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                    <option value="0.5" <?= $plan['risk'] == '0.5' ? 'selected' : '' ?>>0.5%</option>
                                    <option value="1" <?= $plan['risk'] == '1' ? 'selected' : '' ?>>1%</option>
                                    <option value="1.5" <?= $plan['risk'] == '1.5' ? 'selected' : '' ?>>1.5%</option>
                                    <option value="2" <?= $plan['risk'] == '2' ? 'selected' : '' ?>>2%</option>
                                    <option value="2.5" <?= $plan['risk'] == '2.5' ? 'selected' : '' ?>>2.5%</option>
                                    <option value="3" <?= $plan['risk'] == '3' ? 'selected' : '' ?>>3%</option>
                                </select>
                                <input type="hidden" name="risk" value="<?= $plan['risk'] ?>">
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
                                <option value="strong_uptrend" <?= $plan['trend'] == 'strong_uptrend' ? 'selected' : '' ?>>Strong Uptrend</option>
                                <option value="weak_uptrend" <?= $plan['trend'] == 'weak_uptrend' ? 'selected' : '' ?>>Weak Uptrend</option>
                                <option value="ranging" <?= $plan['trend'] == 'ranging' ? 'selected' : '' ?>>Ranging</option>
                                <option value="weak_downtrend" <?= $plan['trend'] == 'weak_downtrend' ? 'selected' : '' ?>>Weak Downtrend</option>
                                <option value="strong_downtrend" <?= $plan['trend'] == 'strong_downtrend' ? 'selected' : '' ?>>Strong Downtrend</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Trader Emotion</label>
                            <select name="emotion" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                <option value="confident" <?= $plan['emotion'] == 'confident' ? 'selected' : '' ?>>Confident</option>
                                <option value="optimistic" <?= $plan['emotion'] == 'optimistic' ? 'selected' : '' ?>>Optimistic</option>
                                <option value="neutral" <?= $plan['emotion'] == 'neutral' ? 'selected' : '' ?>>Neutral</option>
                                <option value="anxious" <?= $plan['emotion'] == 'anxious' ? 'selected' : '' ?>>Anxious</option>
                                <option value="fearful" <?= $plan['emotion'] == 'fearful' ? 'selected' : '' ?>>Fearful</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Confidence: <span id="confidenceValue"><?= $plan['confidence'] ?? 50 ?></span>%
                            </label>
                            <input type="range" name="confidence" min="0" max="100" value="<?= $plan['confidence'] ?? 50 ?>"
                                   class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                                   oninput="document.getElementById('confidenceValue').textContent = this.value">
                        </div>
                    </div>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const entryPriceInput = document.querySelector('input[name="entry_price"]');
                    const stopLossInput = document.querySelector('input[name="stop_loss"]');
                    const takeProfitInput = document.querySelector('input[name="take_profit"]');
                    const capitalInput = document.querySelector('input[name="capital"]');
                    const riskPercentInput = document.querySelector('select[name="risk"]');
                    
                    const riskPerShareEl = document.getElementById('riskPerShare');
                    const riskPerTradeEl = document.getElementById('riskPerTrade');
                    const positionSizeEl = document.getElementById('positionSizeDisplay');
                    const riskRewardEl = document.getElementById('riskRewardRatio');
                    
                    [entryPriceInput, stopLossInput, takeProfitInput, capitalInput, riskPercentInput].forEach(input => {
                        input.addEventListener('input', calculateValues);
                    });
                    
                    function calculateValues() {
                        const entryPrice = parseFloat(entryPriceInput.value) || 0;
                        const stopLoss = parseFloat(stopLossInput.value) || 0;
                        const takeProfit = parseFloat(takeProfitInput.value) || 0;
                        const capital = parseFloat(capitalInput.value) || 0;
                        const riskPercent = parseFloat(riskPercentInput.value) || 0;
                        
                        const riskPerShare = Math.abs(entryPrice - stopLoss);
                        const riskPerTrade = (capital * riskPercent) / 100;
                        const positionSize = riskPerShare > 0 ? Math.floor(riskPerTrade / riskPerShare) : 0;
                        const reward = Math.abs(takeProfit - entryPrice);
                        const riskReward = riskPerShare > 0 ? (reward / riskPerShare).toFixed(2) : '0.00';
                        
                        riskPerShareEl.textContent = `₹${riskPerShare.toFixed(5)}`;
                        riskPerTradeEl.textContent = `₹${riskPerTrade.toFixed(2)}`;
                        positionSizeEl.textContent = positionSize.toLocaleString();
                        riskRewardEl.textContent = `1:${riskReward}`;
                        
                        updateRiskVisuals(riskReward);
                    }
                    
                    function updateRiskVisuals(riskReward) {
                        const rr = parseFloat(riskReward);
                        const riskRewardEl = document.getElementById('riskRewardRatio');
                        
                        riskRewardEl.className = 'px-3 py-2 bg-white rounded border';
                        
                        if (rr >= 2) {
                            riskRewardEl.classList.add('text-green-600', 'font-bold');
                        } else if (rr >= 1) {
                            riskRewardEl.classList.add('text-yellow-600', 'font-medium');
                        } else {
                            riskRewardEl.classList.add('text-red-600', 'font-medium');
                        }
                    }
                    
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
                                  placeholder="Describe your trade setup, entry/exit strategy, and any additional notes..."><?= htmlspecialchars($plan['notes']) ?></textarea>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg">
                        Execute Plan
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
$title = 'Execute Plan';
require __DIR__ . '/../layout/layout.php';
?>
