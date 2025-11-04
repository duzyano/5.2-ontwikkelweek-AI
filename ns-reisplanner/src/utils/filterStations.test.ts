import { describe, it, expect } from 'vitest';
import { filterStations } from './filterStations';

const stations = ['Amsterdam Centraal', 'Utrecht Centraal', 'Eindhoven Centraal', 'Rotterdam Centraal'];

describe('filterStations', () => {
  it('returns empty if input shorter than 2', () => {
    expect(filterStations(stations, 'A')).toEqual([]);
  });

  it('filters stations case-insensitive', () => {
    expect(filterStations(stations, 'am')).toEqual(['Amsterdam Centraal']);
  });

  it('excludes station when specified', () => {
    expect(filterStations(stations, 'centraal', 'Amsterdam Centraal')).toEqual(['Utrecht Centraal', 'Eindhoven Centraal', 'Rotterdam Centraal']);
  });
});
