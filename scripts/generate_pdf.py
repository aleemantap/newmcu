#!/usr/bin/env python3
# import sys
# from weasyprint import HTML
# from pathlib import Path

# def convert_html_to_pdf(html_path, output_path):
#     try:
#         HTML(filename=html_path, base_url=Path(html_path).parent).write_pdf(output_path)
#         print(f"✅ PDF berhasil dibuat: {output_path}")
#     except Exception as e:
#         print(f"❌ Gagal generate PDF: {e}")

# if __name__ == "__main__":
#     if len(sys.argv) != 3:
#         print("Usage: python3 generate_pdf.py input.html output.pdf")
#         sys.exit(1)

#     html_path = sys.argv[1]
#     output_path = sys.argv[2]
#     convert_html_to_pdf(html_path, output_path)

# import sys
# from weasyprint import HTML

# if len(sys.argv) < 3:
#     print("Usage: generate_pdf.py input.html output.pdf")
#     sys.exit(1)

# input_html = sys.argv[1]
# output_pdf = sys.argv[2]

# HTML(filename=input_html).write_pdf(output_pdf)
# print("PDF generated successfully!")

import sys
from weasyprint import HTML
import os

if len(sys.argv) < 3:
    print("Usage: generate_pdf.py input.html output.pdf")
    sys.exit(1)

input_html = sys.argv[1]
output_pdf = sys.argv[2]

# Tambahkan base_url supaya relative image path di HTML bisa dibaca
base_url = os.path.dirname(input_html)

HTML(filename=input_html, base_url=base_url).write_pdf(output_pdf)
print("PDF generated successfully!")
