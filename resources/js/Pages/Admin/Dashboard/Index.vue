<template>
    <Head>
        <title>Dashboard - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">

            <div class="col-12 col-sm-6 col-xl-3 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div
                                class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-info rounded me-4 me-sm-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-back icon icon-md" viewBox="0 0 16 16">
                                        <path d="M0 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2z"/>
                                    </svg>
                                </div>
                                <div class="d-sm-none">
                                    <h2 class="h5">Area</h2>
                                    <h3 class="fw-extrabold mb-1">{{ areas }}</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h5">Area</h2>
                                    <h3 class="fw-extrabold mb-1">{{ areas }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div
                                class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-success rounded me-4 me-sm-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-people-fill icon icon-md" viewBox="0 0 16 16">
                                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                        <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                    </svg>
                                </div>
                                <div class="d-sm-none">
                                    <h2 class="h5">Partisipan</h2>
                                    <h3 class="fw-extrabold mb-1">{{ participants }}</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h5">Partisipan</h2>
                                    <h3 class="fw-extrabold mb-1">{{ participants }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div
                                class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-pencil-square icon icon-md" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </div>
                                <div class="d-sm-none">
                                    <h2 class="h5">Ujian</h2>
                                    <h3 class="fw-extrabold mb-1">{{ exams }}</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h5">Ujian</h2>
                                    <h3 class="fw-extrabold mb-1">{{ exams }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div
                                class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-danger rounded me-4 me-sm-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-stopwatch icon icon-md" viewBox="0 0 16 16">
                                        <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5V5.6z"/>
                                        <path d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64a.715.715 0 0 1 .012-.013l.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354a.512.512 0 0 1-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5zM8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3z"/>
                                    </svg>
                                </div>
                                <div class="d-sm-none">
                                    <h2 class="h5">Sesi Ujian</h2>
                                    <h3 class="fw-extrabold mb-1">{{ exam_sessions }}</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h5">Sesi Ujian</h2>
                                    <h3 class="fw-extrabold mb-1">{{ exam_sessions }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/abstract/abs046.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 22C7.4 22 7 21.6 7 21V9C7 8.4 7.4 8 8 8C8.6 8 9 8.4 9 9V21C9 21.6 8.6 22 8 22Z" fill="currentColor"/>
                        <path opacity="0.3" d="M4 15C3.4 15 3 14.6 3 14V6C3 5.4 3.4 5 4 5C4.6 5 5 5.4 5 6V14C5 14.6 4.6 15 4 15ZM13 19V3C13 2.4 12.6 2 12 2C11.4 2 11 2.4 11 3V19C11 19.6 11.4 20 12 20C12.6 20 13 19.6 13 19ZM17 16V5C17 4.4 16.6 4 16 4C15.4 4 15 4.4 15 5V16C15 16.6 15.4 17 16 17C16.6 17 17 16.6 17 16ZM21 18V10C21 9.4 20.6 9 20 9C19.4 9 19 9.4 19 10V18C19 18.6 19.4 19 20 19C20.6 19 21 18.6 21 18Z" fill="currentColor"/>
                        </svg>
                        </span>
                        <!--end::Svg Icon--> Assesment Result</h5>
                        <div class="chart-container">
                            <apexchart
                                type="bar"
                                :options="assessmentChartOptions"
                                :series="assessmentSeries"
                                height="310"
                            ></apexchart>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/graphs/gra010.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.0021 10.9128V3.01281C13.0021 2.41281 13.5021 1.91281 14.1021 2.01281C16.1021 2.21281 17.9021 3.11284 19.3021 4.61284C20.7021 6.01284 21.6021 7.91285 21.9021 9.81285C22.0021 10.4129 21.5021 10.9128 20.9021 10.9128H13.0021Z" fill="currentColor"/>
                            <path opacity="0.3" d="M11.0021 13.7128V4.91283C11.0021 4.31283 10.5021 3.81283 9.90208 3.91283C5.40208 4.51283 1.90209 8.41284 2.00209 13.1128C2.10209 18.0128 6.40208 22.0128 11.3021 21.9128C13.1021 21.8128 14.7021 21.3128 16.0021 20.4128C16.5021 20.1128 16.6021 19.3128 16.1021 18.9128L11.0021 13.7128Z" fill="currentColor"/>
                            <path opacity="0.3" d="M21.9021 14.0128C21.7021 15.6128 21.1021 17.1128 20.1021 18.4128C19.7021 18.9128 19.0021 18.9128 18.6021 18.5128L13.0021 12.9128H20.9021C21.5021 12.9128 22.0021 13.4128 21.9021 14.0128Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon--> Level Stream</h5>
                        <div class="chart-container">
                            <apexchart
                                type="pie"
                                :options="levelStreamChartOptions"
                                :series="levelStreamSeries"
                                height="320"
                            ></apexchart>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard tabel Level Stream per Regional -->
        <div class="row mt-1 mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5><!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/general/gen002.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M4.05424 15.1982C8.34524 7.76818 13.5782 3.26318 20.9282 2.01418C21.0729 1.98837 21.2216 1.99789 21.3618 2.04193C21.502 2.08597 21.6294 2.16323 21.7333 2.26712C21.8372 2.37101 21.9144 2.49846 21.9585 2.63863C22.0025 2.7788 22.012 2.92754 21.9862 3.07218C20.7372 10.4222 16.2322 15.6552 8.80224 19.9462L4.05424 15.1982ZM3.81924 17.3372L2.63324 20.4482C2.58427 20.5765 2.5735 20.7163 2.6022 20.8507C2.63091 20.9851 2.69788 21.1082 2.79503 21.2054C2.89218 21.3025 3.01536 21.3695 3.14972 21.3982C3.28408 21.4269 3.42387 21.4161 3.55224 21.3672L6.66524 20.1802L3.81924 17.3372ZM16.5002 5.99818C16.2036 5.99818 15.9136 6.08615 15.6669 6.25097C15.4202 6.41579 15.228 6.65006 15.1144 6.92415C15.0009 7.19824 14.9712 7.49984 15.0291 7.79081C15.0869 8.08178 15.2298 8.34906 15.4396 8.55884C15.6494 8.76862 15.9166 8.91148 16.2076 8.96935C16.4986 9.02723 16.8002 8.99753 17.0743 8.884C17.3484 8.77046 17.5826 8.5782 17.7474 8.33153C17.9123 8.08486 18.0002 7.79485 18.0002 7.49818C18.0002 7.10035 17.8422 6.71882 17.5609 6.43752C17.2796 6.15621 16.8981 5.99818 16.5002 5.99818Z" fill="currentColor"/>
                                    <path d="M4.05423 15.1982L2.24723 13.3912C2.15505 13.299 2.08547 13.1867 2.04395 13.0632C2.00243 12.9396 1.9901 12.8081 2.00793 12.679C2.02575 12.5498 2.07325 12.4266 2.14669 12.3189C2.22013 12.2112 2.31752 12.1219 2.43123 12.0582L9.15323 8.28918C7.17353 10.3717 5.4607 12.6926 4.05423 15.1982ZM8.80023 19.9442L10.6072 21.7512C10.6994 21.8434 10.8117 21.9129 10.9352 21.9545C11.0588 21.996 11.1903 22.0083 11.3195 21.9905C11.4486 21.9727 11.5718 21.9252 11.6795 21.8517C11.7872 21.7783 11.8765 21.6809 11.9402 21.5672L15.7092 14.8442C13.6269 16.8245 11.3061 18.5377 8.80023 19.9442ZM7.04023 18.1832L12.5832 12.6402C12.7381 12.4759 12.8228 12.2577 12.8195 12.032C12.8161 11.8063 12.725 11.5907 12.5653 11.4311C12.4057 11.2714 12.1901 11.1803 11.9644 11.1769C11.7387 11.1736 11.5205 11.2583 11.3562 11.4132L5.81323 16.9562L7.04023 18.1832Z" fill="currentColor"/>
                                    </svg>
                                    </span>
                                    <!--end::Svg Icon--> Level Stream per Regional</h5>
                            <button @click="exportAllToExcel" class="btn btn-success btn-sm text-white">
                                <i class="fas fa-file-excel me-1 text-white"></i> Export Excel
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">No.</th>
                                        <th class="border-0">TREG Area</th>
                                        <th class="border-0">Starter 🌱</th>
                                        <th class="border-0">Basic 🥉</th>
                                        <th class="border-0">Intermediate 🥈</th>
                                        <th class="border-0">Advanced 🥇</th>
                                        <th class="border-0 rounded-end" style="width:15%">Expert 💎</th>
                                    </tr>
                                </thead>
                                <div class="mt-2"></div>
                                <tbody>
                                    <tr v-for="(stat, index) in filteredAreaStats" :key="index">
                                        <td class="fw-bold text-center">{{ index + 1 }}</td>
                                        <td>{{ stat.title }}</td>
                                        <td class="text-center cursor-pointer" @click="showParticipants(stat.title, 'starter', stat.starter_participants)">{{ stat.starter }}</td>
                                        <td class="text-center cursor-pointer" @click="showParticipants(stat.title, 'basic', stat.basic_participants)">{{ stat.basic }}</td>
                                        <td class="text-center cursor-pointer" @click="showParticipants(stat.title, 'intermediate', stat.intermediate_participants)">{{ stat.intermediate }}</td>
                                        <td class="text-center cursor-pointer" @click="showParticipants(stat.title, 'advanced', stat.advanced_participants)">{{ stat.advanced }}</td>
                                        <td class="text-center cursor-pointer" @click="showParticipants(stat.title, 'expert', stat.expert_participants)">{{ stat.expert }}</td>
                                    </tr>
                                    <tr class="bg-light fw-bold">
                                        <td colspan="2" class="text-center">Total</td>
                                        <td class="text-center cursor-pointer" @click="showAllParticipantsByLevel('starter')">{{ getTotalByLevel('starter') }}</td>
                                        <td class="text-center cursor-pointer" @click="showAllParticipantsByLevel('basic')">{{ getTotalByLevel('basic') }}</td>
                                        <td class="text-center cursor-pointer" @click="showAllParticipantsByLevel('intermediate')">{{ getTotalByLevel('intermediate') }}</td>
                                        <td class="text-center cursor-pointer" @click="showAllParticipantsByLevel('advanced')">{{ getTotalByLevel('advanced') }}</td>
                                        <td class="text-center cursor-pointer" @click="showAllParticipantsByLevel('expert')">{{ getTotalByLevel('expert') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
    <!-- Modal -->
    <div class="modal fade" id="participantsModal" tabindex="-1" aria-labelledby="participantsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullwidth">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="participantsModalLabel">{{ modalTitle }}</h5>
                    <div>
                        <button @click="exportToExcel" class="btn btn-success btn-sm me-2 text-white">
                            <i class="fas fa-file-excel me-1 text-white"></i> Export Excel
                        </button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <div v-if="selectedParticipants && selectedParticipants.length > 0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:10%">No.</th>
                                        <th class="border-0">Nama</th>
                                        <th class="border-0">TREG - Area</th>
                                        <th class="border-0">Witel</th>
                                        <th class="border-0">Nilai</th>
                                        <th class="border-0 rounded-end" style="width:20%">Level Stream</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(participant, index) in selectedParticipants" :key="index">
                                        <td class="text-center">{{ index + 1 }}</td>
                                        <td>{{ participant.name }}</td>
                                        <td>{{ participant.areas }}</td>
                                        <td>{{ participant.witel || '-' }}</td>
                                        <td class="text-center">{{ participant.grade }}</td>
                                        <td class="text-center">{{ participant.level }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div v-else class="text-center">
                        No participants found
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        <!-- End Dashboard tabel level stream per regional -->

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/general/gen020.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 18V16H10V18L9 20H15L14 18Z" fill="currentColor"/>
                            <path opacity="0.3" d="M20 4H17V3C17 2.4 16.6 2 16 2H8C7.4 2 7 2.4 7 3V4H4C3.4 4 3 4.4 3 5V9C3 11.2 4.8 13 7 13C8.2 14.2 8.8 14.8 10 16H14C15.2 14.8 15.8 14.2 17 13C19.2 13 21 11.2 21 9V5C21 4.4 20.6 4 20 4ZM5 9V6H7V11C5.9 11 5 10.1 5 9ZM19 9C19 10.1 18.1 11 17 11V6H19V9ZM17 21V22H7V21C7 20.4 7.4 20 8 20H16C16.6 20 17 20.4 17 21ZM10 9C9.4 9 9 8.6 9 8V5C9 4.4 9.4 4 10 4C10.6 4 11 4.4 11 5V8C11 8.6 10.6 9 10 9ZM10 13C9.4 13 9 12.6 9 12V11C9 10.4 9.4 10 10 10C10.6 10 11 10.4 11 11V12C11 12.6 10.6 13 10 13Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon--> Top Participant per Regional</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">No.</th>
                                        <th class="border-0">Regional</th>
                                        <th class="border-0">Nama</th>
                                        <th class="border-0">Witel</th>
                                        <th class="border-0">Nilai</th>
                                        <th class="border-0 rounded-end">Level Stream</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="topParticipantsByRegional.length > 0">
                                        <template v-for="(participant, index) in topParticipantsByRegional" :key="index">
                                            <tr>
                                                <td class="text-center">{{ index + 1 }}</td>
                                                <td v-if="index === 0 || participant.regional !== topParticipantsByRegional[index-1].regional" 
                                                    :rowspan="getRegionalRowspan(participant.regional)">
                                                    {{ participant.regional }}
                                                </td>
                                                <td>{{ participant.name }}</td>
                                                <td>{{ participant.witel }}</td>
                                                <td class="text-center">{{ participant.grade }}</td>
                                                <td class="text-center">{{ participant.level }}</td>
                                            </tr>
                                        </template>
                                    </template>
                                    <tr v-else>
                                        <td colspan="6" class="text-center">No data available</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
//import layout Admin
import LayoutAdmin from '../../../Layouts/Admin.vue';
//import Head from Inertia
import { Head } from '@inertiajs/vue3';
//import ApexCharts
import VueApexCharts from 'vue3-apexcharts';

    export default {

        //layout
        layout: LayoutAdmin,

        //register components
        components: {
            Head,
            apexchart: VueApexCharts
        },

        //props
        props: {
            participants: Number,
            exams: Number,
            exam_sessions: Number,
            areas: Number,
            areaLevelStats: Array,
            assessmentData: Object, // Add this line
        },

        computed: {
            filteredAreaStats() {
                if (!this.areaLevelStats) return [];
                return this.areaLevelStats.filter(stat => !stat.title.toLowerCase().includes('nasional'));
            },
        levelStreamSeries() {
            return [
                this.getTotalByLevel('starter'),
                this.getTotalByLevel('basic'),
                this.getTotalByLevel('intermediate'),
                this.getTotalByLevel('advanced'),
                this.getTotalByLevel('expert')
            ];
        },
        topParticipantsByRegional() {
            if (!this.areaLevelStats) return [];
            
            const topParticipants = [];
            this.filteredAreaStats.forEach(stat => {
                const allParticipants = [];
                
                ['starter', 'basic', 'intermediate', 'advanced', 'expert'].forEach(level => {
                    const participants = stat[`${level}_participants`] || [];
                    participants.forEach(p => {
                        allParticipants.push({
                            ...p,
                            name: p.name,
                            witel: p.witel || '-',  // Ensure witel has a fallback value
                            grade: p.grade,
                            level: level
                        });
                    });
                });
                
                const topTwo = allParticipants
                    .sort((a, b) => b.grade - a.grade)
                    .slice(0, 2)
                    .map(p => ({
                        ...p,
                        regional: stat.title,
                        witel: p.witel || '-',  // Preserve witel in the final mapping
                        level: this.getLevelWithEmoji(p.level)
                    }));
                    
                if (topTwo.length > 0) {
                    topParticipants.push(...topTwo);
                }
            });
            
            return topParticipants;
        },
        assessmentSeries() {
        if (!this.assessmentData) {
            // Fallback to hardcoded data if no backend data
            return [{
                name: 'Starter 🌱',
                data: [3, 10, 3, 1, 2]
            }, {
                name: 'Basic 🥉',
                data: [4, 2, 9, 5, 5]
            }, {
                name: 'Intermediate 🥈',
                data: [4, 8, 2, 4, 9]
            }, {
                name: 'Advanced 🥇',
                data: [7, 6, 8, 8, 3]
            }, {
                name: 'Expert 💎',
                data: [2, 1, 1, 5, 2]
            }];
        }
        
        return [{
            name: 'Starter 🌱',
            data: this.assessmentData.starter || []
        }, {
            name: 'Basic 🥉',
            data: this.assessmentData.basic || []
        }, {
            name: 'Intermediate 🥈',
            data: this.assessmentData.intermediate || []
        }, {
            name: 'Advanced 🥇',
            data: this.assessmentData.advanced || []
        }, {
            name: 'Expert 💎',
            data: this.assessmentData.expert || []
        }];
     }
    },
    data() {
        return {
            modalTitle: '',
            selectedParticipants: [],
            modal: null,

            assessmentChartOptions: {
                chart: {
                    type: 'bar',
                    stacked: false,
                    toolbar: {
                        show: true
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '90%',  // Changed from 55% to 70%
                        endingShape: 'flat'
                    }
                },
                grid: {
                    borderColor: '#e7e7e7',
                    row: {
                        colors: ['transparent', 'transparent'],
                        opacity: 0.5
                    }
                },
                xaxis: {
                    categories: ['MECHANICAL', 'ELECTRICAL', 'MAINTENANCE', 'MONITORING', 'AUTOMATION' , 'ATTITUDE', 'PRAKTIK'],
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },  // Added missing comma here
                yaxis: {
                    title: {
                        text: 'Number of Teknisi'
                    },
                    min: 0,
                    // Remove max: 10 to allow dynamic scaling
                    tickAmount: 6,
                    forceNiceScale: true // This ensures nice round numbers on the scale
                },
                colors: ['#00e396', '#008ffb', '#feb019', '#ff6178', '#8b75d7'],
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    fontSize: '12px'
                },
                dataLabels: {
                    enabled: false
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function (val) {
                            return val + " Teknisi"
                        }
                    }
                }
            },
            levelStreamChartOptions: {
                chart: {
                    type: 'pie',
                },
                labels: ['Starter 🌱', 'Basic 🥉', 'Intermediate 🥈', 'Advanced 🥇', 'Expert 💎'],
                colors: ['#00e396', '#008ffb', '#feb019', '#ff6178', '#8b75d7'],
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val, opts) {
                        return val.toFixed(1) + '%'  // Show percentage with 1 decimal place
                    }
                },
                tooltip: {
                    enabled: true,
                    formatter: function(val, opts) {
                        const total = opts.series.reduce((a, b) => a + b, 0);
                        const percentage = ((val / total) * 100).toFixed(1);
                        return '<b>' + opts.w.config.labels[opts.seriesIndex] + '</b><br/>' + 
                               'Count: ' + val + '<br/>' + 
                               'Percentage: ' + percentage + '%';
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            }
        }
    },

    mounted() {
        this.modal = new bootstrap.Modal(document.getElementById('participantsModal'));
    },

    methods: {
        // In showParticipants method
        showParticipants(area, level, participants) {
            const levelEmoji = {
                'starter': '🌱',
                'basic': '🥉',
                'intermediate': '🥈',
                'advanced': '🥇',
                'expert': '💎'
            };
            
            this.modalTitle = `${area} - ${level.charAt(0).toUpperCase() + level.slice(1)} Level ${levelEmoji[level]}`;
            this.selectedParticipants = participants.map(participant => ({
                ...participant,
                areas: area,
                witel: participant.witel,  // Preserve witel
                level: `${level.charAt(0).toUpperCase() + level.slice(1)} ${levelEmoji[level]}`
            })) || [];
            this.modal.show();
        },
        getRegionalRowspan(regional) {
            return this.topParticipantsByRegional.filter(p => p.regional === regional).length;
        },
        // In showAllParticipantsByLevel method 
        showAllParticipantsByLevel(level) {
            const levelEmoji = {
                'starter': '🌱',
                'basic': '🥉',
                'intermediate': '🥈',
                'advanced': '🥇',
                'expert': '💎'
            };
            
            const allParticipants = [];
            this.filteredAreaStats.forEach(stat => {
                const participants = stat[`${level}_participants`] || [];
                participants.forEach(p => {
                    allParticipants.push({
                        ...p,
                        areas: stat.title,
                        witel: p.witel,  // Preserve witel
                        level: `${level.charAt(0).toUpperCase() + level.slice(1)} ${levelEmoji[level]}`
                    });
                });
            });
        
            this.modalTitle = `All ${level.charAt(0).toUpperCase() + level.slice(1)} Level ${levelEmoji[level]} Participants`;
            this.selectedParticipants = allParticipants;
            this.modal.show();
        },
        
        // In exportAllToExcel method
        exportAllToExcel() {
            const allParticipants = [];
            
            this.filteredAreaStats.forEach(stat => {
                ['starter', 'basic', 'intermediate', 'advanced', 'expert'].forEach(level => {
                    const participants = stat[`${level}_participants`] || [];
                    participants.forEach(p => {
                        allParticipants.push({
                            name: p.name,
                            areas: stat.title,
                            witel: p.witel,  // Add witel to export
                            grade: p.grade,
                            level: this.getLevelWithEmoji(level)
                        });
                    });
                });
            });
        
            // Update headers to include Witel
            const headers = ['No.', 'Nama', 'TREG - Area', 'Witel', 'Nilai', 'Level Stream'];
            const csvContent = [
                headers,
                ...allParticipants.map((p, index) => [
                    index + 1,
                    p.name,
                    p.areas,
                    p.witel || '-',
                    p.grade,
                    p.level
                ])
            ].map(row => row.join(',')).join('\n');

            // Create and trigger download
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', 'Level_Stream_per_Regional.csv');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },

        getLevelWithEmoji(level) {
            const levelEmoji = {
                'starter': '🌱',
                'basic': '🥉',
                'intermediate': '🥈',
                'advanced': '🥇',
                'expert': '💎'
            };
            return `${level.charAt(0).toUpperCase() + level.slice(1)} ${levelEmoji[level] || ''}`;
        },
        getTotalByLevel(level) {
            return this.filteredAreaStats.reduce((total, stat) => total + (stat[level] || 0), 0);
        },
            exportToExcel() {
            // Create CSV content
            const headers = ['No.', 'Nama', 'TREG - Area', 'Witel', 'Nilai', 'Level Stream'];
                const csvContent = [
                    headers,
                    ...this.selectedParticipants.map((p, index) => [
                        index + 1,
                        p.name,
                        p.areas,
                        p.witel || '-',
                        p.grade,
                        p.level
                    ])
                ].map(row => row.join(',')).join('\n');

            // Create and trigger download
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `${this.modalTitle.replace(/[^\w\s]/gi, '_')}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        },
            

        }

</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
.cursor-pointer:hover {
    background-color: rgba(0,0,0,0.05);
}
.modal-fullwidth {
    max-width: 70%;
    width: 70%;
    margin: 1.75rem auto;
}
</style>