Title: Add NS Reisplanner (React + TypeScript) with simulated data and tooling

Description:
This PR adds a simple NS-like travel planner implemented in React + TypeScript using Vite.

Main changes:
- Add `src/components/NsReisplanner.tsx` (main UI, uses simulated data if no NS API key is provided)
- Add `src/services/nsApi.ts` with optional NS API integration (falls back to simulation)
- Add Vite + TypeScript config, Tailwind config, and basic Tailwind setup
- Add unit test for `filterStations` using Vitest
- Add README and .env.example

Notes for reviewers:
- To run locally: `npm install && npm run dev`
- If you have an NS API key, copy `.env.example` to `.env` and set `REACT_APP_NS_API_KEY`.
- Tests: `npm run test` (requires dependencies installed)

Follow-up tasks (optional):
- Improve styling with Tailwind fully enabled
- Add real API mapping for station search endpoints and better error handling
- Add E2E tests and CI pipeline
