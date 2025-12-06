<?php
ob_start();
?>
<div class="px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Edit Trade Plan</h1>

        <form action="/plans/<?= $plan['id'] ?>/update" method="POST" class="space-y-6">
            <!-- Trading Setup Section -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Trading Setup</h2>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Trading Setup</label>
                    <select name="setup_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <?php foreach ($setups as $setup): ?>
                        <option value="<?= $setup['id'] ?>" <?= $setup['id'] == $plan['setup_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($setup['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Trade Details Section -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Trade Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Symbol</label>
                        <input type="text" name="symbol" required value="<?= htmlspecialchars($plan['symbol']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                               placeholder="e.g., RELIANCE">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Sector</label>
                        <select name="sector" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="">Select Sector</option>
                            <option value="Technology" <?= $plan['sector'] === 'Technology' ? 'selected' : '' ?>>Technology</option>
                            <option value="Financials" <?= $plan['sector'] === 'Financials' ? 'selected' : '' ?>>Financials</option>
                            <option value="Healthcare" <?= $plan['sector'] === 'Healthcare' ? 'selected' : '' ?>>Healthcare</option>
                            <option value="Consumer Cyclical" <?= $plan['sector'] === 'Consumer Cyclical' ? 'selected' : '' ?>>Consumer Cyclical</option>
                            <option value="Industrials" <?= $plan['sector'] === 'Industrials' ? 'selected' : '' ?>>Industrials</option>
                            <option value="Energy" <?= $plan['sector'] === 'Energy' ? 'selected' : '' ?>>Energy</option>
                            <option value="Utilities" <?= $plan['sector'] === 'Utilities' ? 'selected' : '' ?>>Utilities</option>
                            <option value="Communication" <?= $plan['sector'] === 'Communication' ? 'selected' : '' ?>>Communication</option>
                            <option value="Consumer Defensive" <?= $plan['sector'] === 'Consumer Defensive' ? 'selected' : '' ?>>Consumer Defensive</option>
                            <option value="Basic Materials" <?= $plan['sector'] === 'Basic Materials' ? 'selected' : '' ?>>Basic Materials</option>
                            <option value="Real Estate" <?= $plan['sector'] === 'Real Estate' ? 'selected' : '' ?>>Real Estate</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Industry</label>
                        <select name="industry" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="">Select Industry</option>
                            <option value="Software" <?= $plan['industry'] === 'Software' ? 'selected' : '' ?>>Software</option>
                            <option value="Semiconductors" <?= $plan['industry'] === 'Semiconductors' ? 'selected' : '' ?>>Semiconductors</option>
                            <option value="Banks" <?= $plan['industry'] === 'Banks' ? 'selected' : '' ?>>Banks</option>
                            <option value="Pharmaceuticals" <?= $plan['industry'] === 'Pharmaceuticals' ? 'selected' : '' ?>>Pharmaceuticals</option>
                            <option value="Automobiles" <?= $plan['industry'] === 'Automobiles' ? 'selected' : '' ?>>Automobiles</option>
                            <option value="Oil & Gas" <?= $plan['industry'] === 'Oil & Gas' ? 'selected' : '' ?>>Oil & Gas</option>
                            <option value="Telecom" <?= $plan['industry'] === 'Telecom' ? 'selected' : '' ?>>Telecom</option>
                            <option value="Retail" <?= $plan['industry'] === 'Retail' ? 'selected' : '' ?>>Retail</option>
                            <option value="Manufacturing" <?= $plan['industry'] === 'Manufacturing' ? 'selected' : '' ?>>Manufacturing</option>
                            <option value="Other" <?= $plan['industry'] === 'Other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Direction</label>
                        <select name="direction" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="long" <?= $plan['direction'] === 'long' ? 'selected' : '' ?>>Long</option>
                            <option value="short" <?= $plan['direction'] === 'short' ? 'selected' : '' ?>>Short</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Timeframe</label>
                            <select name="timeframe" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                <option value="1m" <?= $plan['timeframe'] === '1m' ? 'selected' : '' ?>>1m</option>
                                <option value="5m" <?= $plan['timeframe'] === '5m' ? 'selected' : '' ?>>5m</option>
                                <option value="15m" <?= $plan['timeframe'] === '15m' ? 'selected' : '' ?>>15m</option>
                                <option value="1h" <?= $plan['timeframe'] === '1h' ? 'selected' : '' ?>>1h</option>
                                <option value="4h" <?= $plan['timeframe'] === '4h' ? 'selected' : '' ?>>4h</option>
                                <option value="1d" <?= $plan['timeframe'] === '1d' ? 'selected' : '' ?>>1d</option>
                                <option value="1w" <?= $plan['timeframe'] === '1w' ? 'selected' : '' ?>>1w</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Entry TF</label>
                            <select name="entry_timeframe" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                <option value="1m" <?= $plan['entry_timeframe'] === '1m' ? 'selected' : '' ?>>1m</option>
                                <option value="5m" <?= $plan['entry_timeframe'] === '5m' ? 'selected' : '' ?>>5m</option>
                                <option value="15m" <?= $plan['entry_timeframe'] === '15m' ? 'selected' : '' ?>>15m</option>
                                <option value="1h" <?= $plan['entry_timeframe'] === '1h' ? 'selected' : '' ?>>1h</option>
                                <option value="4h" <?= $plan['entry_timeframe'] === '4h' ? 'selected' : '' ?>>4h</option>
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
                        <label class="block text-gray-700 text-sm font-bold mb-2">Entry Price (₹)</label>
                        <input type="number" step="0.01" name="entry_price" required 
                               value="<?= htmlspecialchars($plan['entry_price']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                               oninput="calculateMetrics()">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Stop Loss (₹)</label>
                        <input type="number" step="0.01" name="stop_loss" required 
                               value="<?= htmlspecialchars($plan['stop_loss']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                               oninput="calculateMetrics()">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Take Profit (₹)</label>
                        <input type="number" step="0.01" name="take_profit" required 
                               value="<?= htmlspecialchars($plan['take_profit']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                               oninput="calculateMetrics()">
                    </div>
                </div>
            </div>

            <!-- Risk Management Section -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Risk Management</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Capital (₹)</label>
                            <input type="number" step="0.01" name="capital" required 
                                   value="<?= htmlspecialchars($plan['capital']) ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                   oninput="calculateMetrics()">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Risk Percentage</label>
                            <select name="risk" required 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                    onchange="calculateMetrics()">
                                <option value="0.5" <?= $plan['risk'] == 0.5 ? 'selected' : '' ?>>0.5%</option>
                                <option value="1" <?= $plan['risk'] == 1 ? 'selected' : '' ?>>1%</option>
                                <option value="1.5" <?= $plan['risk'] == 1.5 ? 'selected' : '' ?>>1.5%</option>
                                <option value="2" <?= $plan['risk'] == 2 ? 'selected' : '' ?>>2%</option>
                                <option value="2.5" <?= $plan['risk'] == 2.5 ? 'selected' : '' ?>>2.5%</option>
                                <option value="3" <?= $plan['risk'] == 3 ? 'selected' : '' ?>>3%</option>
                            </select>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-600 text-xs font-semibold uppercase mb-1">Risk/Share</label>
                                <div class="px-3 py-2 bg-white rounded border" id="riskPerShare">₹<?= number_format($plan['risk_per_share'] ?? 0, 5) ?></div>
                            </div>
                            <div>
                                <label class="block text-gray-600 text-xs font-semibold uppercase mb-1">Risk/Trade</label>
                                <div class="px-3 py-2 bg-white rounded border" id="riskPerTrade">₹<?= number_format($plan['risk_per_trade'] ?? 0, 2) ?></div>
                            </div>
                            <div>
                                <label class="block text-gray-600 text-xs font-semibold uppercase mb-1">Position Size</label>
                                <div class="px-3 py-2 bg-white rounded border" id="positionSizeDisplay"><?= $plan['position_size'] ?? 0 ?></div>
                            </div>
                            <div>
                                <label class="block text-gray-600 text-xs font-semibold uppercase mb-1">Capital Used</label>
                                <div class="px-3 py-2 bg-white rounded border" id="capitalUsed">₹<?= number_format($plan['capital_used'] ?? 0, 2) ?></div>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-600 text-xs font-semibold uppercase mb-1">Risk:Reward Ratio</label>
                                <div class="px-3 py-2 bg-white rounded border text-center font-bold" id="riskRewardRatio" style="color: #10B981;">
                                    <?= number_format($plan['risk_reward_ratio'] ?? 0, 2) ?>:1
                                </div>
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
                        <label class="block text-gray-700 text-sm font-bold mb-2">Trend</label>
                        <select name="trend" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="uptrend" <?= $plan['trend'] === 'uptrend' ? 'selected' : '' ?>>Uptrend</option>
                            <option value="downtrend" <?= $plan['trend'] === 'downtrend' ? 'selected' : '' ?>>Downtrend</option>
                            <option value="sideways" <?= $plan['trend'] === 'sideways' ? 'selected' : '' ?>>Sideways</option>
                            <option value="ranging" <?= $plan['trend'] === 'ranging' ? 'selected' : '' ?>>Ranging</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Emotion</label>
                        <select name="emotion" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="fear" <?= $plan['emotion'] === 'fear' ? 'selected' : '' ?>>Fear</option>
                            <option value="greed" <?= $plan['emotion'] === 'greed' ? 'selected' : '' ?>>Greed</option>
                            <option value="neutral" <?= $plan['emotion'] === 'neutral' ? 'selected' : '' ?>>Neutral</option>
                            <option value="euphoria" <?= $plan['emotion'] === 'euphoria' ? 'selected' : '' ?>>Euphoria</option>
                            <option value="panic" <?= $plan['emotion'] === 'panic' ? 'selected' : '' ?>>Panic</option>
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

            <!-- Trade Notes & Analysis Section -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Trade Notes & Analysis</h2>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
                    <textarea name="notes" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                              placeholder="Enter your trade analysis, setup details, and any other relevant information..."><?= htmlspecialchars($plan['notes']) ?></textarea>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg">
                    Update Plan
                </button>
                <a href="/plans" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Edit Plan';
require __DIR__ . '/../layout/layout.php';
?>