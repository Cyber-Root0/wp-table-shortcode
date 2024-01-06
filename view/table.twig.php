<div x-data="{ current: 1 }">
        <h2 class="elementor-heading-title elementor-size-default">{{table.title}}</h2>
        <div class="flex overflow-hidden border-b-2">
            <button class="px-4 py-2 w-full" x-on:click="current = 1"
                x-bind:class="{ 'text-white bg-blue-600': current === 1 }">Masculino</button>
            <button class="px-4 py-2 w-full" x-on:click="current = 2"
                x-bind:class="{ 'text-white bg-blue-600': current === 2 }">Feminino</button>
        </div>
        <div x-show="current === 1" class="p-3 text-center mt-6">
           <div id="grid-masc"></div>
        </div>
        <div x-show="current === 2" class="p-3 text-center mt-6" id="">
             <div id="grid-fem"></div>
        </div>
        <div x-show="current === 3" class="p-3 text-center mt-6">
            <p>Third Tab Content</p>
        </div>
        <script>
                // Ensure the Grid class is defined before using it
                document.addEventListener('DOMContentLoaded', function () {
                    const grid = new gridjs.Grid({
                        columns: {{table.columns | raw}} ,
                        data: {{table.data.masculino | raw}},
                        sort: true,
                        search: true
                    }).render(document.getElementById('grid-masc'));
                    const grid2 = new gridjs.Grid({
                        columns: {{table.columns | raw}} ,
                        data: {{table.data.feminino | raw}},
                        sort: true,
                        search: true
                    }).render(document.getElementById('grid-fem'));
                });
        </script>
    </div>