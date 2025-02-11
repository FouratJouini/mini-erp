$(document).ready(function () {
    $('#grandTotalSpan').append('<button id="grandTotalCalc" class="btn btn-secondary mt-2">Calculer</button>');
    
    $("#articles").change(function () {
        $('#grandTotalPannel').show();
        let selectedOption = $(this).find(":selected");
        let selectedText = selectedOption.text();
        let selectedValue = selectedOption.val();
        let prixGros = selectedOption.data("pg");
        let prixDetail = selectedOption.data("pd");

        if (selectedValue) {
            let articlesPanel = $("#articlesPannel");
            let newRow = $(`
                <div class="article-row form-row align-items-center mb-3">
                    <div class="col-auto">
                        <span>${selectedText}</span>
                    </div>
                    <div class="col-auto">
                        <label class="sr-only" for="modePrix">Mode prix</label>
                        <select name="modePrix" class="modePrix form-control" data-prixGros="${prixGros}" data-prixDetail="${prixDetail}">
                            <option value="0">mode prix</option>
                            <option value="1">Gros</option>
                            <option value="2">details</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <label class="sr-only" for="pu">PU</label>
                        <input type="number" class="pu form-control" name="articles[${selectedValue}][pu]" placeholder="PU" required>
                    </div>
                    <div class="col-auto">
                        <label class="sr-only" for="qty">Quantité</label>
                        <input type="number" class="qty form-control" name="articles[${selectedValue}][qty]" placeholder="Quantité" min="1" required>
                    </div>
                    <div class="col-auto">
                        <label class="sr-only" for="rem">REM</label>
                        <input type="number" class="rem form-control" name="articles[${selectedValue}][rem]" placeholder="REM" min="0" max="99" required>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="sum-article btn btn-info">Calculer</button>
                    </div>
                    <div class="col-auto">
                        <label class="sr-only" for="totalht">TOTAL HT</label>
                        <input type="number" class="totalht form-control" name="articles[${selectedValue}][total_ht]" placeholder="TOTAL HT" required>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="remove-article btn btn-danger">Remove</button>
                    </div>
                </div>
            `);

            articlesPanel.append(newRow);
        }
    });

    // Remove article row when clicking the remove button
    $(document).on("click", ".remove-article", function () {
        $(this).closest('.article-row').remove();
        $('#grandTotal').val(null);
    });

    // Use event delegation to handle change event for dynamically added .modePrix elements
    $(document).on("change", ".modePrix", function () {
        let priceMode = $(this).val();
        if(priceMode == 0) {
            alert('séléctionner le mode de prix');
            $(this).closest('.article-row').find(".pu").val(null);
        }
        if(priceMode == 1){
            let pu = $(this).data("prixgros");
            $(this).closest('.article-row').find(".pu").val(pu);
        }
        if(priceMode == 2){
            let pu = $(this).data("prixdetail");
            $(this).closest('.article-row').find(".pu").val(pu);
        }
    });

    $(document).on("click", ".sum-article", function () {
        let pu = $(this).closest('.article-row').find(".pu").val();
        let qty = $(this).closest('.article-row').find(".qty").val();
        let rem = $(this).closest('.article-row').find(".rem").val();
        let totalHT = pu * qty * (1 - rem / 100);
        $(this).closest('.article-row').find(".totalht").val(totalHT);
    });

    $(document).on("change", "#transport_base", function () {
        let base = $("#transport_base").val();
        let total = base * 0.93;
        $('#transport_total').val(total);
    });

    // Calculate grand total when clicking the grandTotalCalc button
    $(document).on("click", "#grandTotalCalc", function (event) {
        event.preventDefault(); // Prevent form submission
        let grandTotal = 0;
        $(".article-row").each(function () {
            let totalHT = parseFloat($(this).find(".totalht").val()) || 0;
            grandTotal += totalHT;
        });
        let transportTotal = parseFloat($("#transport_total").val()) || 0;
        grandTotal = (grandTotal * 1.19) + transportTotal + 1;
        $('#grandTotal').val(grandTotal);
    });
});