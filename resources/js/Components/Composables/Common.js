import { router, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import * as XLSX from "xlsx";

export default function common() {
    let sortKey = '';
    let sortDirection = 'asc';

    const sortTable = (key, data) => {
        if (key === 'action') return data;

        if (sortKey === key) {
            sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            sortKey = key;
            sortDirection = 'asc';
        }

        const sortedData = [...data].sort((a, b) => {
            let valA = a[key];
            let valB = b[key];

            if (valA == null) valA = '';
            if (valB == null) valB = '';
            
            if (key === 'id') {
                valA = parseInt(valA) || 0;
                valB = parseInt(valB) || 0;
            }

            if (typeof valA === 'string') valA = valA.toLowerCase();
            if (typeof valB === 'string') valB = valB.toLowerCase();

            if (valA < valB) return sortDirection === 'asc' ? -1 : 1;
            if (valA > valB) return sortDirection === 'asc' ? 1 : -1;
            return 0;
        });

        return sortedData;
    };
    
    let isFormSubmiting = ref(false);

    const CardInquiryFrom = useForm({
        name: '',
        email: '',
        phone: '',
        message: '',
    });

    function submitCardInquiryForm(url) {
        isFormSubmiting.value = true;
        CardInquiryFrom.errors = {},
        router.post(url, CardInquiryFrom, {
            preserveScroll: true,
            onSuccess: () => {
                CardInquiryFrom.reset();
            },
            onError: (errors) => {
                isFormSubmiting.value = false;
                CardInquiryFrom.errors = errors;
            },
            onFinish: () => {
                isFormSubmiting.value = false;
            },
        });
    }

    // const exportToExcel = (tableId = "spots-report", filename = "table-data.xlsx") => {

    //     const table = document.getElementById(tableId);

    //     if (!table) {
    //         console.error(`Table with id "${tableId}" not found`);
    //         return;
    //     }

    //     const worksheet = XLSX.utils.table_to_sheet(table);
    //     const workbook = XLSX.utils.book_new();
    //     XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");

    //     // Auto-adjust column widths
    //     const wscols = [];
    //     const maxColLengths = {};

    //     // Calculate maximum content length for each column
    //     XLSX.utils.sheet_to_json(worksheet).forEach(row => {
    //         Object.keys(row).forEach(col => {
    //             let val = row[col] == null ? "" : String(row[col]);
    //             if (/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(val)) {
    //                 const [day, month, year] = val.split("/").map(Number);
    //                 val = `${day}-${month}-${year}`;
    //             }
    //             console.log(val)
    //             if (maxColLengths[col] === undefined || val.length > maxColLengths[col]) {
    //                 maxColLengths[col] = val.length;
    //             }
    //         });
    //     });

    //     // Set column widths (add some padding)
    //     Object.keys(maxColLengths).forEach(col => {
    //         wscols.push({ wch: Math.min(Math.max(maxColLengths[col] + 2, 10), 50) });
    //     });
        
    //     worksheet['!cols'] = wscols;

    //     // XLSX.writeFile(workbook, filename);
    // };

    const exportToExcel = (tableId = "spots-report", filename = "table-data.xlsx") => {
        const table = document.getElementById(tableId);
        if (!table) {
            console.error(`Table with id "${tableId}" not found`);
            return;
        }

        const worksheet = XLSX.utils.table_to_sheet(table, { raw: false });

        // Force all date-like values to D-M-YYYY string
        Object.keys(worksheet).forEach(cellAddr => {
            if (cellAddr[0] === '!') return; // skip metadata
            const cell = worksheet[cellAddr];
            if (!cell || cell.v == null) return;

            let val = cell.v;

            // Detect Excel serial number date
            if (!isNaN(val) && Number(val) > 40000 && Number(val) < 60000) {
                const utcDays = Math.floor(val - 25569);
                const utcValue = utcDays * 86400;
                const dateInfo = new Date(utcValue * 1000);
                const day = dateInfo.getUTCDate();
                const month = dateInfo.getUTCMonth() + 1;
                const year = dateInfo.getUTCFullYear();
                cell.v = `${day}-${month}-${year}`;
                cell.t = "s";
            }
            // Detect date strings with slashes (D/M/YYYY or M/D/YYYY)
            else if (/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(val)) {
                let [p1, p2, year] = val.split("/").map(Number);
                const day = p1 > 12 ? p1 : p2;   // pick correct day
                const month = p1 > 12 ? p2 : p1; // pick correct month
                cell.v = `${day}-${month}-${year}`;
                cell.t = "s";
            }
            // Detect date strings with dashes (D-M-YYYY or M-D-YYYY)
            else if (/^\d{1,2}-\d{1,2}-\d{4}$/.test(val)) {
                let [p1, p2, year] = val.split("-").map(Number);
                const day = p1 > 12 ? p1 : p2;
                const month = p1 > 12 ? p2 : p1;
                cell.v = `${day}-${month}-${year}`;
                cell.t = "s";
            }
        });

        // Auto column width
        const wscols = [];
        const maxColLengths = {};
        XLSX.utils.sheet_to_json(worksheet).forEach(row => {
            Object.keys(row).forEach(col => {
                const val = row[col] == null ? "" : String(row[col]);
                if (maxColLengths[col] === undefined || val.length > maxColLengths[col]) {
                    maxColLengths[col] = val.length;
                }
            });
        });
        Object.keys(maxColLengths).forEach(col => {
            wscols.push({ wch: Math.min(Math.max(maxColLengths[col] + 2, 10), 50) });
        });
        worksheet['!cols'] = wscols;

        // Save file
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");
        XLSX.writeFile(workbook, filename);
    };

    return {
        sortTable,
        submitCardInquiryForm,
        CardInquiryFrom,
        isFormSubmiting,
        exportToExcel,
    };
}