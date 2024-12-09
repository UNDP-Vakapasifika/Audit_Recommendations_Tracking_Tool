
<div class="container mx-auto">
    <h1 class="text-2xl font-semibold mb-4">Reports</h1>

    <h2 class="text-xl font-semibold mb-2">Accepted Recommendations</h2>
    <x-report-table :recommendations="$acceptedRecommendations" />

    <h2 class="text-xl font-semibold mb-2">Fully Implemented Recommendations</h2>
    <x-report-table :recommendations="$implementedRecommendations" />

    <h2 class="text-xl font-semibold mb-2">Partially Implemented Recommendations</h2>
    <x-report-table :recommendations="$partiallyImplementedRecommendations" />

    <h2 class="text-xl font-semibold mb-2">Not Implemented Recommendations</h2>
    <x-report-table :recommendations="$notImplementedRecommendations" />

    <h2 class="text-xl font-semibold mb-2">Repeated Finding Recommendations (Yes)</h2>
    <x-report-table :recommendations="$recurrenceYesRecommendations" />

    <x-report-table :recommendations="$acceptedRecommendations" />

</div>