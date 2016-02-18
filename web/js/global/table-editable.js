var TableEditable = function () {

    var handleTable = function (id, category) {

        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);

            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }

            oTable.fnDraw();
        }

        function editRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);

            var str = aData[0];
            if(category == 'link' || category == 'video') {
                var myRe = /<a.*?>(.*)<\/a>/ig;
                var myArray = myRe.exec(aData[0]);
                if(myArray) {
                    str = myArray[1];
                }
            }
            var jqTds = $('>td', nRow);
            jqTds[0].innerHTML = '<input type="text" class="form-control input-sm" value="' + str + '">';
            jqTds[1].innerHTML = '<a class="btn default btn-xs blue edit"><i class="fa fa-save"></i> Save </a><a class="btn default btn-xs black cancel"><i class="fa fa-mail-reply"></i> Cancel </a>';
        }

        function saveRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
            var str = jqInputs[0].value;
            var link = str;
            if(category == 'link') {
                if(str.indexOf("http://") != 0 && str.indexOf("https://") != 0)
                {
                    link = 'http://' + str;
                }
                str = '<a href="' + link + '" onclick="return !window.open(this.href)">' + link + '</a>';
            }
            else if(category == 'video') {
                if(str.indexOf("http://www.youtube.com/watch?v=") != 0 && str.indexOf("https://www.youtube.com/watch?v=") != 0)
                {
                    link = 'http://www.youtube.com/watch?v=' + str;
                }
                str = '<a href="' + link + '" onclick="return !window.open(this.href)">' + link + '</a>';
            }
            jqInputs[0].value = link;
            update_link(oTable, nRow);
            oTable.fnUpdate(str, nRow, 0, false);
            oTable.fnUpdate('<a class="btn default btn-xs purple edit"><i class="fa fa-edit"></i> Edit </a><a class="btn btn-danger btn-xs black delete"><i class="fa fa-trash-o"></i> Delete </a>', nRow, 1, false);
            oTable.fnDraw();
        }

        function cancelEditRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
            var str = jqInputs[0].value;
            if(category == 'link') {
                if(str.indexOf("http://") != 0 && str.indexOf("https://") != 0)
                {
                    str = 'http://' + str;
                }
                oTable.fnUpdate('<a href="' + str + '" onclick="return !window.open(this.href)">' + str + '</a>', nRow, 0, false);
            }
            else if(category == 'video') {
                if(str.indexOf("http://www.youtube.com/watch?v=") != 0 && str.indexOf("https://www.youtube.com/watch?v=") != 0)
                {
                    str = 'http://www.youtube.com/watch?v=' + str;
                }
                oTable.fnUpdate('<a href="' + str + '"> onclick="return !window.open(this.href)"' + str + '</a>', nRow, 0, false);
            }
            else
                oTable.fnUpdate(str, nRow, 0, false);
            oTable.fnUpdate('<a class="btn default btn-xs purple edit"><i class="fa fa-edit"></i> Edit </a><a class="btn btn-danger btn-xs black delete"><i class="fa fa-trash-o"></i> Delete </a>', nRow, 1, false);
            oTable.fnDraw();
        }

        function update_link(oTable, nRow) {
            var jqInputs = $('input', nRow);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'update_' + category,
                data: 'row=' + nRow.rowIndex + '&name=' + jqInputs[0].value + '&id=' + id + '&_csrf='+$("meta[name=csrf-token]").attr("content"),
                success:function (json) {
                }
            });
        }
        function delete_link(nRow) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'delete_' + category,
                data: 'row=' + nRow.rowIndex + '&id=' + id + '&_csrf='+$("meta[name=csrf-token]").attr("content"),
                success:function (json) {
                }
            });
        }

        var table = $('#' + category + '_editable');

        var oTable = table.dataTable({
          //  "columnDefs": [ { targets: 'no-sort', orderable: false } ],
            "aoColumns" : [
                { sWidth: '80%' },
                { sWidth: '20%' },
            ],
            "pageLength": 2,
            order: [],
            "searching": false,
            "bLengthChange": false,
            "bPaginate": false,
            "oLanguage": {"sZeroRecords": "", "sEmptyTable": ""}
        });

        var nEditing = null;
        var nNew = false;

        $('#' + category + '_editable_new').click(function (e) {
            e.preventDefault();

            if (nEditing) {
                $(nEditing).find(".edit").click();
                nEditing = null;
                nNew = false;
            }

            var aiNew = oTable.fnAddData(['', '']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            editRow(oTable, nRow);
            nEditing = nRow;
            nNew = true;
        });

        table.on('click', '.delete', function (e) {
            e.preventDefault();

            if (confirm("Are you sure to delete this row ?") == false) {
                return;
            }

            var nRow = $(this).parents('tr')[0];
            delete_link(nRow);
            oTable.fnDeleteRow(nRow);
        });

        table.on('click', '.cancel', function (e) {
            e.preventDefault();
            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
        });

        table.on('click', '.edit', function (e) {
            e.preventDefault();

            /* Get the row as a parent of the link that was clicked on */
            var nRow = $(this).parents('tr')[0];

            if (nEditing !== null && nEditing != nRow) {
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else if (nEditing == nRow && this.innerHTML == '<i class="fa fa-save"></i> Save ') {
                /* Editing this row and want to save it */
                saveRow(oTable, nEditing);
                nEditing = null;
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
            nNew = false;
        });
    };

    return {

        //main function to initiate the module
        init: function (id,category) {
            handleTable(id,category);
        }
    };

}();