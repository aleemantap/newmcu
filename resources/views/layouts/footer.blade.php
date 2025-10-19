
                <footer>
                    <div class="footer-area">
                        <p>© Copyright 2018. All right reserved. Template by <a href="https://colorlib.com/wp/">Colorlib</a>.</p>
                    </div>
                </footer>
            </div>
            <!-- GLOBAL SCRIPT -->
            <script>
            // This is global base url
            // don't change this if you
            // don't underderstand
            // what this global variable
            // functionality
            baseUrl = "{{ URL::to('/') }}";
            base_sound = baseUrl+'/assets/css/lobibox/sounds/'; 
            //baseUrl = "{{ secure_url('/') }}";
			//console.log("base URL", baseUrl);
            //baseUrl = "https://gmeds.plazamedis.web.id";
            </script>
                <!-- jquery latest version -->
            <script src="{{ asset('assets/js/vendor/jquery-2.2.4.min.js') }}"></script>
            <!-- bootstrap 4 js -->
            <script src="{{ asset('assets/js/popper.min.js') }}"></script>
            <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
            <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
            <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
            <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
            <script src="{{ asset('assets/js/jquery.slicknav.min.js') }}"></script>
            
            <!-- start chart js -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
            <!-- start highcharts js -->
            <script src="https://code.highcharts.com/highcharts.js"></script>
            <!-- start zingchart js -->
            <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
            <script>
            zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
            ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
            </script>
            <!-- all line chart activation -->
            <script src="{{ asset('assets/js/line-chart.js') }}"></script>
            <!-- all pie chart -->
            <script src="{{ asset('assets/js/pie-chart.js') }}"></script>

            <!-- Start datatable js -->
            <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
            <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
            @yield('script')
            <script>
                $(document).ready(function () {
                    $(".data-tables")
                    .find(".input-group")
                    .find("input")
                    .removeClass("form-control-sm");
                });
            </script>
           
            <!-- others plugins -->
            <script src="{{ asset('assets/js/plugins.js') }}"></script>
            <script src="{{ asset('assets/js/scripts.js') }}"></script>
            <script src="{{ asset('assets/js/lobibox/Lobibox.js') }}"></script>
             <!-- END GLOBAL SCRIPT -->
           
    </body>
</html>
