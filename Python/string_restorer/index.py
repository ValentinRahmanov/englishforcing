from string_processor import StringProcessor
import json

with open('config.json', 'r', encoding='utf-8') as file:
    data = json.load(file)

string_decoder = StringProcessor(data["file_to_read"], data["file_with_result"])

string_decoder.read_string_from_input_file()

string_decoder.culc_last_elem_index()

string_decoder.add_spaces_between_numbers_and_letters()

string_decoder.replace_numbers_with_needed_letter_repeats()

string_decoder.write_the_result_in_output_file()