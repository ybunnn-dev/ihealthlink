<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Title -->
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Reports</h1>
            <!-- Upper Card -->
            <div class="bg-white rounded-xl overflow-hidden p-6 mb-3">
                <div class="grid grid-cols-1 xl:grid-cols-5 xl:items-end gap-4">
                    <div class="col-span-1 xl:col-span-2">
                        <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search for Reports</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..."/>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 slg2:grid-cols-2 lg3:grid-cols-4 gap-4 items-center col-span-1 xl:col-span-3">
                        <div class="col-span-1">
                            <label for="filterDropdown" class="mb-2 text-sm font-medium text-main_font">Report Type</label>
                            <button id="filterDropdown" data-dropdown-toggle="filterDropdownMenu" class="w-full text-main_font bg-[#F7F7F7] focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                Alphabetical
                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-span-1">
                            <label for="filterDropdown" class="mb-2 text-sm font-medium text-main_font">Date</label>
                            <button id="filterDropdown" data-dropdown-toggle="filterDropdownMenu" class="w-full text-main_font bg-[#F7F7F7] focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                Alphabetical
                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                        </div>

                        <div class="col-span-1">
                            <label for="targetPopulationDropdown" class="mb-2 text-sm font-medium text-main_font">Purok</label>
                            <button id="targetPopulationDropdown" data-dropdown-toggle="targetPopulationDropdownMenu" class="w-full text-main_font bg-[#F7F7F7] focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                All
                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                        </div>

                        <div class="col-span-1">
                            <button type="button" class="w-3/4 h-[2rem] text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-3">Export</button>
                        </div>
                    </div>
                </div>
                 <div id="filterDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                    <ul class="py-2 text-sm text-gray-700">
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Alphabetical</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Most Enrolled</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Least Enrolled</a></li>
                    </ul>
                </div>
                <div id="filterDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                    <ul class="py-2 text-sm text-gray-700">
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Alphabetical</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Most Enrolled</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Least Enrolled</a></li>
                    </ul>
                </div>
                <div id="targetPopulationDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                    <ul class="py-2 text-sm text-gray-700">
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">All</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Children</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Adolescent</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Adults</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Elderly</a></li>
                    </ul>
                </div>
            </div>
            <div class="mb-3">
                <x-reports-tab></x-reports-tab>
            </div>
            <div class="grid grid-cols-1 lg2:grid-cols-1 xl:grid-cols-5 gap-4">
                <div class="grid grid-cols-1 lg:grid-cols-3 xl:grid-cols-1 gap-4 col-span-1">
                    <div class="bg-f7 rounded-xl p-6 text-center">
                        <div class="flex items-center justify-center xl:justify-start gap-8 xl:gap-8 pl-4">
                            <svg class="text-sub_blue w-10 h-10" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 273.052 273.052" xml:space="preserve" fill="currentColor">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> 
                                    <g> 
                                        <circle style="fill:currentColor" cx="138.173" cy="73.52" r="73.52"></circle> 
                                        <path style="fill:currentColor;" d="M126.381,171.369c6.728,3.236,17.65,3.236,24.378,0l67.047-32.243 c6.734-3.236,13.989-0.082,16.208,7.054l20.032,64.35c2.219,7.136,0.234,17.65-4.433,23.48l-1.137,1.425 c-3.807,4.759-11.058,8.784-17.661,24.797c-2.85,6.913-10.378,12.82-17.846,12.82H63.043c-7.473,0-14.99-5.901-17.873-12.793 c-6.679-15.947-14.163-19.776-18.259-24.291l-3.263-3.612c-5.015-5.537-6.995-15.719-4.427-22.735L42.5,145.974 c2.567-7.016,10.106-10.079,16.839-6.842L126.381,171.369z"></path> 
                                    </g> 
                                </g>
                             </svg>   
                            <div class="flex flex-col">
                                <h1 class="text-sub_blue text-lg slg3:text-xl xl:text-xl 2xl:text-2xl font-bold mt-2">5,201</h1>
                                <p class="text-sub_blue text-xs -mt-1 slg3:text-fluid-xxs xl:text-xs 2xl:text-xs">Residents</p>
                            </div>
                        </div>
                    </div>
                     <div class="bg-f7 rounded-xl p-6 text-center">
                        <div class="flex items-center justify-center xl:justify-start gap-8 xl:gap-8 pl-4">
                            <svg class="text-sub_blue w-10 h-10" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 273.052 273.052" xml:space="preserve" fill="currentColor">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> 
                                    <g> 
                                        <circle style="fill:currentColor" cx="138.173" cy="73.52" r="73.52"></circle> 
                                        <path style="fill:currentColor;" d="M126.381,171.369c6.728,3.236,17.65,3.236,24.378,0l67.047-32.243 c6.734-3.236,13.989-0.082,16.208,7.054l20.032,64.35c2.219,7.136,0.234,17.65-4.433,23.48l-1.137,1.425 c-3.807,4.759-11.058,8.784-17.661,24.797c-2.85,6.913-10.378,12.82-17.846,12.82H63.043c-7.473,0-14.99-5.901-17.873-12.793 c-6.679-15.947-14.163-19.776-18.259-24.291l-3.263-3.612c-5.015-5.537-6.995-15.719-4.427-22.735L42.5,145.974 c2.567-7.016,10.106-10.079,16.839-6.842L126.381,171.369z"></path> 
                                    </g> 
                                </g>
                             </svg>   
                            <div class="flex flex-col">
                                <h1 class="text-sub_blue text-lg slg3:text-xl xl:text-xl 2xl:text-2xl font-bold mt-2">5,201</h1>
                                <p class="text-sub_blue text-xs -mt-1 slg3:text-fluid-xxs xl:text-xs 2xl:text-xs">Residents</p>
                            </div>
                        </div>
                    </div>
                     <div class="bg-f7 rounded-xl p-6 text-center">
                        <div class="flex items-center justify-center xl:justify-start gap-8 xl:gap-8 pl-4">
                            <svg class="text-sub_blue w-10 h-10" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 273.052 273.052" xml:space="preserve" fill="currentColor">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> 
                                    <g> 
                                        <circle style="fill:currentColor" cx="138.173" cy="73.52" r="73.52"></circle> 
                                        <path style="fill:currentColor;" d="M126.381,171.369c6.728,3.236,17.65,3.236,24.378,0l67.047-32.243 c6.734-3.236,13.989-0.082,16.208,7.054l20.032,64.35c2.219,7.136,0.234,17.65-4.433,23.48l-1.137,1.425 c-3.807,4.759-11.058,8.784-17.661,24.797c-2.85,6.913-10.378,12.82-17.846,12.82H63.043c-7.473,0-14.99-5.901-17.873-12.793 c-6.679-15.947-14.163-19.776-18.259-24.291l-3.263-3.612c-5.015-5.537-6.995-15.719-4.427-22.735L42.5,145.974 c2.567-7.016,10.106-10.079,16.839-6.842L126.381,171.369z"></path> 
                                    </g> 
                                </g>
                             </svg>   
                            <div class="flex flex-col">
                                <h1 class="text-sub_blue text-lg slg3:text-xl xl:text-xl 2xl:text-2xl font-bold mt-2">5,201</h1>
                                <p class="text-sub_blue text-xs -mt-1 slg3:text-fluid-xxs xl:text-xs 2xl:text-xs">Residents</p>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="bg-white rounded-xl p-6 px-10 shadow-sm col-span-1 xl:col-span-4">
                    <h3 class="text-lg font-semibold text-main_font mb-4">Age Group</h3>
                    <div class="flex items-center justify-center h-[80%]">
                        <canvas id="ageGroupChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
</x-app-layout>
<script>
  const ctx = document.getElementById('ageGroupChart').getContext('2d');

  // Generate 18 example age groups
  const ageGroups = [
      '0-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39',
      '40-44', '45-49', '50-54', '55-59', '60-64', '65-69', '70-74', '75-79',
      '80-84', '85+'
  ];

  // Sample data for male and female counts for 18 age groups
  // **Replace this with your actual data**
  const maleData = [
      50, 55, 60, 65, 70, 75, 80, 78, 72, 68, 62, 58, 52, 45, 38, 30, 25, 20
  ];
  const femaleData = [
      48, 58, 63, 68, 72, 78, 82, 80, 75, 70, 65, 60, 55, 48, 40, 32, 28, 22
  ];

  const stackedBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ageGroups,
      datasets: [
        {
          label: 'Male',
          data: maleData,
          backgroundColor: 'lightcoral', // You can customize colors
          borderColor: 'lightcoral',
          borderWidth: 1
        },
        {
          label: 'Female',
          data: femaleData,
          backgroundColor: 'deepskyblue', // You can customize colors
          borderColor: 'deepskyblue',
          borderWidth: 1
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false, // Allows height to be set by CSS/attribute
      scales: {
        x: {
          stacked: true,
        },
        y: {
          stacked: true,
          beginAtZero: true,
          title: {
            display: true,
            text: 'Number of Residents'
          }
        }
      },
      plugins: {
        title: {
          display: false, // Title is handled by the <h3> tag above the canvas
          text: 'Age Group Demographics'
        },
        tooltip: {
            mode: 'index',
            intersect: false,
            callbacks: {
                footer: (tooltipItems) => {
                    let sum = 0;
                    tooltipItems.forEach(function(tooltipItem) {
                        sum += tooltipItem.parsed.y;
                    });
                    return 'Total: ' + sum;
                }
            }
        }
      }
    }
  });
</script>







