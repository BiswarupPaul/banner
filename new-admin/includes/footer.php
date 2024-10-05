</div>
</div>

</div>
<!-- End of Main Content -->

<!-- Footer -->
<!-- Footer -->
<footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->




    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <!-- <script src="vendor/chart.js/Chart.min.js"></script> -->

    <!-- Page level custom scripts -->
    <!-- <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script> -->


        <!-- Page level plugins -->
    <!-- <script src="vendor/datatables/jquery.dataTables.min.js"></script> -->
    <!-- <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script> -->

    <!-- Page level custom scripts -->
    <!-- <script src="js/demo/datatables-demo.js"></script> -->
    <script src="vendors/jquery.dataTables.min.js"></script>
    <script src="vendors/dataTables.bootstrap5.min.js"></script>
    <script src="vendors/dataTables.responsive.min.js"></script>

    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#mySummernote").summernote({
                height:250
            });
            $('.dropdown-toggle').dropdown();
        });

  
    </script>



<script> 
  
  // Initialize the DataTable 
  jQuery(document).ready(function () { 
    jQuery('#example').DataTable({ 

          // Disable the searching  
          // of the DataTable 
          searching: true,
      }); 
  }); 
</script> 

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<!-- <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script> -->
<!-- <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script> -->

<!-- <script>
    CKEDITOR.replace('blog_content', {
    extraPlugins: 'wordcount',
    wordcount: {
        showWordCount: true,
        showCharCount: false,
        countSpacesAsChars: true,
        countHTML: false,
        maxWordCount: 200,
        maxCharCount: 2000
    }
});

</script> -->

<script type="text/javascript">
    $(document).ready(function()
    {
        var editor = CKEDITOR.replace('blog_content');
        editor.on("instanceReady", function(){
            this.document.on("keyup", ck_jq);
            this.document.on("paste", ck_jq);
        });

    });

    function ck_jq()
    {
        var len = CKEDITOR.instances['blog_content'].getData().replace(/<("[^"]*"|'[^']*'|[^'">])*>/gi, '').replace(/^\s+|\s+$/g, '');
        $("#display_count").val(len.length);
    }

    </script>


<script>

CKEDITOR.editorConfig = function(config) {
    // Add the wordcount and notification plugins
    config.extraPlugins = 'wordcount,notification';

    // Customize your toolbar
    config.toolbar = [
        { name: 'document', items: ['Source', 'NewPage', 'Preview', 'Print', 'Templates'] },
        { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'Undo', 'Redo'] },
        { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll'] },
        { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar'] },
        { name: 'tools', items: ['Maximize', 'ShowBlocks', 'About'] },
        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
        // Add more toolbar groups and items as needed
    ];

    // Optional: Configure word count settings
    config.wordcount = {
        // Your word count configuration here, e.g., limit
        showWordCount: true,
        showCharCount: true,
        showParagraphCount: true,
        showSentenceCount: true,
        showElementCount: true,
        countSpacesAsChars: true,
        countLineBreaksAsChars: true
    };

    // Optional: Configure notification plugin settings if necessary
    // You can customize the notification behavior here
};



</script>

 <!-- <script type="text/javascript">
    $(document).ready(function() {
        var maxWords = 10; // Set your word limit here

        var editor = CKEDITOR.replace('blog_content');

        editor.on("instanceReady", function() {
            this.document.on("keyup", updateWordCount);
            this.document.on("paste", updateWordCount);
        });

        function updateWordCount() {
            var content = this.getData();
            var text = content.replace(/<[^>]*>/g, ''); // Remove HTML tags
            var words = text.trim().split(/\s+/);

            var wordCount = words.filter(function(word) {
                return word.length > 0;
            }).length;

            $("#wordCount").val(wordCount);

            if (wordCount > maxWords) {
                alert("You have exceeded the word limit of " + maxWords + " words.");
                this.setData(content.substring(0, content.lastIndexOf(' '))); // Removes last word
            }
        }
    });
</script>  -->



</body>
</html>