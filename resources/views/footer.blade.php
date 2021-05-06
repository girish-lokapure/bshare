<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"--}}
{{--        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"--}}
{{--        crossorigin="anonymous"></script>--}}

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
-->
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
{{--<script type="text/javascript" charset="utf8"--}}
{{--        src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>--}}

<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript" charset="utf8"
        src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>


<script>
    $(document).ready(function () {

        $('#reset').click(function () {

            $('#createCustomer .modal-data-id').val(0);
        })

        var table = $('#example').DataTable({

            "processing": true,
            "serverSide": true,
            "ajax": "/list",
            "columnDefs": [{"orderable": false, "targets": [0, 4, 5, 6, 9, 11, 12]}]
        });
        $('#example tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }

        });

        //Delete customer
        $('#delete').click(function () {

            var id = $('tr.selected').children().first().text();

            if (id == '') {
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: "/delete/" + id,
                success: function () {
                    table.row('.selected').remove().draw(false);
                },
                error: function () {
                    alert("Error occurred while trying to delete.");
                }
            });

        });

        // Add customer
        $('#add').click(function () {
            $('#createCustomer .modal-title').html('Create Customer');
            $('#createCustomer .modal-data-id').val(0);
            $('#createCustomer [name|="company"]').val('').change();
            $('#createCustomer [name|="first_name"]').val('').change();
            $('#createCustomer [name|="last_name"]').val('').change();
            $('#createCustomer [name|="email_address"]').val('').change();
            $('#createCustomer [name|="job_title"]').val('').change();
            $('#createCustomer [name|="business_phone"]').val('').change();
            $('#createCustomer [name|="address"]').val('').change();
            $('#createCustomer [name|="city"]').val('').change();
            $('#createCustomer [name|="zip_postal_code"]').val('').change();
            $('#createCustomer [name|="country_region"]').val('').change();
            $('#createCustomer').modal();

        });
        // Edit Customer
        $('#edit').click(function () {

            // var id = $('tr.selected').children().first().text()

            var child = $('tr.selected').children('td')
            if (child.first().text() == 0) {
                alert('bla');
                return false;
            }

            $('#createCustomer .modal-title').html('Edit Customer');
            $('#createCustomer .modal-data-id').val(child.eq(0).text());
            $('#createCustomer [name|="company"]').val(child.eq(1).text()).change();
            $('#createCustomer [name|="first_name"]').val(child.eq(2).text()).change();
            $('#createCustomer [name|="last_name"]').val(child.eq(3).text()).change();
            $('#createCustomer [name|="email_address"]').val(child.eq(4).text()).change();
            $('#createCustomer [name|="job_title"]').val(child.eq(5).text()).change();
            $('#createCustomer [name|="business_phone"]').val(child.eq(6).text()).change();
            $('#createCustomer [name|="address"]').val(child.eq(7).text()).change();
            $('#createCustomer [name|="city"]').val(child.eq(8).text()).change();
            $('#createCustomer [name|="zip_postal_code"]').val(child.eq(9).text()).change();
            $('#createCustomer [name|="country_region"]').val(child.eq(10).text()).change();

            $('#createCustomer').modal();

        });
        $("#customer_form").submit(function (e) {
            e.preventDefault();
            let id = $('#createCustomer .modal-data-id').val()
            const formData = $('#customer_form').serialize();
            let url = '';
            let type = '';
            if (id == 0) {
                url = '/create';
                type = 'POST';
            } else {
                url = '/update/' + id;
                type = 'PUT';
            }

            $.ajax({
                url: url,
                type: type,
                data: formData,
                success: function (result) {
                    if (!result.error) {
                        $('#createCustomer .close').click();
                        $('#customer_form').trigger("reset");
                        table.clear().draw();

                    } else {
                        // alert(result.msg);
                    }
                },
                error: function (result) {
                    console.log(result.responseJSON.message);
                    alert(result.responseJSON.message + '\n' + JSON.stringify(result.responseJSON.errors));
                }
            });

        });

    });
</script>
