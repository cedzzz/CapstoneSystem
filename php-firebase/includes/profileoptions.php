
                         


                            
                            
                         

                   
                    <div class="end-bar">

                        <div class="rightbar-title">
                            <a href="javascript:void(0);" class="end-bar-toggle float-end">
                                <i class="dripicons-cross noti-icon"></i>
                            </a>
                            <h5 class="m-0">Settings</h5>
                        </div>

                        <div class="rightbar-content h-100" data-simplebar="">

                            <div class="p-3">


                                <h5 class="mt-3">Color Scheme</h5>
                                <hr class="mt-1">

                                <div class="form-check form-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="color-scheme-mode"
                                        value="light" id="light-mode-check" checked="">
                                    <label class="form-check-label" for="light-mode-check">Light Mode</label>
                                </div>

                                <div class="form-check form-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="color-scheme-mode"
                                        value="dark" id="dark-mode-check">
                                    <label class="form-check-label" for="dark-mode-check">Dark Mode</label>
                                </div>
                                
                            </div> 

                        </div>
                    </div>
                    <div class="rightbar-overlay"></div>
                 
                    <script src="/Capstone_System/assets/js/vendor.min.js"></script>
                    <script src="/Capstone_System/assets/js/app.min.js"></script>

                  
                    <script src="/Capstone_System/assets/js/vendor/apexcharts.min.js"></script>
                    <script src="/Capstone_System/assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
                    <script src="/Capstone_System/assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
                 
                    <script src="/Capstone_System/assets/js/pages/demo.dashboard.js"></script>
                    <script src="https://cdn.ckeditor.com/4.7.0/standard/ckeditor.js"></script>
                    <script>
                        function hideMessage() {
                            document.getElementById("disappMsg").style.display = "none";
                        };
                        setTimeout(hideMessage, 2000);
                        function hideMessage() {
                            document.getElementById("disappMsg").style.display = "none";
                        };
                        setTimeout(hideMessage, 2000);
                        function toggleDropdown(selObj) {
                            if(selObj.value == "Barangay Business Permit")
                            {
                                document.getElementById("businesspermit_type").style.display = "";
                                document.getElementById("barangaypermit_type").style.display = "none";
                                document.getElementById("barangaycertificate_type").style.display = "none";
                                document.getElementById("barangaypermit_type").selectedIndex = 0;
                                document.getElementById("barangaycertificate_type").selectedIndex = 0;


                            }
                            else if (selObj.value == "Barangay Permit")
                            {
                                document.getElementById("businesspermit_type").style.display = "none";
                                document.getElementById("barangaypermit_type").style.display = "";
                                document.getElementById("barangaycertificate_type").style.display = "none";
                                document.getElementById("businesspermit_type").selectedIndex = 0;
                                document.getElementById("barangaycertificate_type").selectedIndex = 0;
                                document.getElementById("otherspermit").style.display = "none";
                            }
                            else if (selObj.value == "Barangay Certificate")
                            {
                                document.getElementById("businesspermit_type").style.display = "none";
                                document.getElementById("barangaypermit_type").style.display = "none";
                                document.getElementById("barangaycertificate_type").style.display = "";
                                document.getElementById("businesspermit_type").selectedIndex = 0;
                                document.getElementById("barangaypermit_type").selectedIndex = 0;
                                document.getElementById("otherspermit").style.display = "none";
                            }
                            else 
                            {
                                document.getElementById("businesspermit_type").style.display = "none";
                                document.getElementById("barangaypermit_type").style.display = "none";
                                document.getElementById("barangaycertificate_type").style.display = "none";
                                document.getElementById("businesspermit_type").selectedIndex = 0;
                                document.getElementById("barangaypermit_type").selectedIndex = 0;
                                document.getElementById("barangaycertificate_type").selectedIndex = 0;
                                document.getElementById("otherspermit").style.display = "none";

                            }

                        }
                    function otherToggle(selectObj)
                    {
                        if(selectObj.value == "Others")
                                {
                                    document.getElementById("otherspermit").style.display = "";
                                    document.getElementById("othersinput").disabled = false;
                                }
                                else
                                {
                                    document.getElementById("otherspermit").style.display = "none";
                                    document.getElementById("othersinput").disabled = true;
                                }
                    }

                    function onChange() 
                    {
                    const password = document.querySelector('input[name=password]');
                    const confirm = document.querySelector('input[name=confirmpassword]');
                        if (confirm.value === password.value) {
                            confirm.setCustomValidity('');
                        } else {
                            confirm.setCustomValidity('Passwords do not match');
                        }
                    }
                    </script>
                    <script>
                     CKEDITOR.replace('incident1');
                     CKEDITOR.instances.incident1.updateElement();
                     incident1 = document.getElementsById('incident1').value;

                        </script>
                        <script>
                        function onChange() {
                        const password = document.querySelector('input[name=password]');
                        const confirmpassword = document.querySelector('input[name=confirmpassword]');
                        if (confirmpassword.value === password.value) {
                            confirmpassword.setCustomValidity('');
                        } else {
                            confirmpassword.setCustomValidity("Your confirm password must be the same as the password you've typed.");
                        }
                        }
                    </script>
